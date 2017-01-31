package src;
import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.concurrent.ConcurrentLinkedQueue;

/**
 * Created by mark on 26-1-2017.
 */
public class sender implements Runnable {
    Connection con;
    ConcurrentLinkedQueue queue2;
    Statement stmt;

    public sender(ConcurrentLinkedQueue queue2){
        this.queue2 = queue2;

    }

    @Override
    public synchronized void run(){

        try {
            System.out.println("Tryin to connect to database..");
            con = DriverManager.getConnection("jdbc:mysql://localhost:3306/unwdmi?autoReconnect=true&useSSL=false","java","root");
            System.out.println("Database is connected..");
            stmt= con.createStatement();
        }
            catch (java.sql.SQLException e ) {
                System.out.println("rip" + e);
            }
        while (true){
            if (!queue2.isEmpty()) {
                try{
                    stmt.execute(queue2.remove().toString());

                }
                catch (java.sql.SQLException e){ System.out.println(e);}



            }

        }
    }
}
