package src;

import java.net.ServerSocket;
import java.net.Socket;
import java.sql.ResultSet;
import java.sql.*;

import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ConcurrentLinkedQueue;

class leertaak3{
    public static void main(String args[]){
        try {
            ///
            Connection con = DriverManager.getConnection("jdbc:mysql://localhost:3306/unwdmi?autoReconnect=true&useSSL=false","java","root");
            ResultSet rs= con.createStatement().executeQuery("select min(STN) AS min,max(STN) AS max FROM stations Where stn between 800010 AND 889030");
            ResultSet chileex =con.createStatement().executeQuery("Select STN from stations Where country Like 'Chile' and STN between 506390 and 593210");
            List<Integer> chilelist = new ArrayList<Integer>();
            while (chileex.next()){
                chilelist.add(chileex.getInt("STN"));
            }
            rs.next();
            int min = rs.getInt("min");
            int max = rs.getInt("max");

            ///
            ServerSocket socket = new ServerSocket(7789);
            ConcurrentLinkedQueue queue1 = new ConcurrentLinkedQueue();
            ConcurrentLinkedQueue queue2 = new ConcurrentLinkedQueue();
            Thread thread1 = new Thread(new parser(queue1,queue2
                    ,min,max,chilelist )); // xml parser
            Thread thread2; // socket reader
            Thread thread3 = new Thread(new sender(queue2)); // sender to database class.
            thread1.start();
            thread3.start();
            Socket sock;
            while(true){
                sock = socket.accept();
                thread2 = new Thread(new socketReader(queue1, sock));
                thread2.start();
           }
        } catch (Exception e) {
            System.out.println("PipeThread Exception: " + e);
        }
    }
}