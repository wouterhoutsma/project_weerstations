package src;
import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.Queue;
import java.util.concurrent.ConcurrentLinkedQueue;

/**
 * Created by mark on 26-1-2017.
 */
public class sender implements Runnable {
    Connection con;
    Queue<measurement> queue2;
    measurement mes;
    CallableStatement cs;
    int i;


    public sender(Queue<measurement> queue2){this.queue2 = queue2;}

    @Override
    public synchronized void run(){

        try {

            //System.out.println("Tryin to connect to database..");
            con = DriverManager.getConnection("jdbc:mysql://145.33.225.149:3306/unwdmi?rewriteBatchedStatements=true","root","root");
            con.setAutoCommit(false);

            //System.out.println("Database is connected..");
            cs = con.prepareCall("insert into measurement (STN,TIMEDATE,TEMP,WNSP) VALUES(?,?,?,?)");
        }
            catch (java.sql.SQLException e ) {
                System.out.println(e);
            }


        while (true){


                try{

                    if((mes=queue2.poll())!=null) {
                        cs.setInt(1, mes.getNumber());
                        cs.setLong(2, mes.getDate());
                        cs.setDouble(3, mes.getTemp());
                        cs.setDouble(4, mes.getWdsp());
                        cs.addBatch();
                        i++;
                        if (i >= 400) {
                            cs.executeBatch();
                            cs.clearBatch();
                            con.commit();
                            i = 0;
                        }
                    }
                    else{this.wait(5);}
                }

                catch (java.sql.SQLException |java.lang.InterruptedException e){ System.out.println(e);}





        }
    }
}
