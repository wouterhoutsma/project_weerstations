package src;

import java.net.ServerSocket;
import java.net.Socket;
import java.sql.ResultSet;
import java.sql.*;

import java.util.ArrayList;
import java.util.List;
import java.util.Queue;
import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.util.concurrent.LinkedBlockingQueue;

class leertaak3{
    public static void main(String args[]){
        try {
            ///
            ExecutorService exec = Executors.newFixedThreadPool(800);// creating fixed threadpool
            Connection con = DriverManager.getConnection("jdbc:mysql://145.33.225.149:3306/unwdmi","root","root");
            ResultSet rs= con.createStatement().executeQuery("select min(STN) AS min,max(STN) AS max FROM stations Where stn between 800010 AND 889030");
            ResultSet chileex =con.createStatement().executeQuery("Select STN from stations Where country Like 'Chile' and STN between 506390 and 593210");
            List<Integer> chilelist = new ArrayList<Integer>();

            while (chileex.next()){
                chilelist.add(chileex.getInt("STN"));
            }
            chileex.close();
            rs.next();
            int min = rs.getInt("min");
            int max = rs.getInt("max");
            rs.close();

            con.close();
            ///
            ServerSocket socket = new ServerSocket(7789);
            ConcurrentLinkedQueue queue1 = new ConcurrentLinkedQueue();
            Queue<measurement> queue2 = new ConcurrentLinkedQueue<>();
            Thread thread1 = new Thread(new parser(queue1,queue2
                    ,min,max,chilelist )); // xml parser
            // socket reader
            Thread thread3 = new Thread(new sender(queue2)); // sender to database class.
            thread1.start();
            thread3.start();
            Socket sock;


            while(true){
                sock = socket.accept();
                //Thread thread2 = new Thread(new socketReader(queue1, socket.accept()));
                //thread2.start();
                exec.execute(new socketReader(queue1, sock));
           }
        } catch (Exception e) {
            System.out.println("PipeThread Exception: " + e);
        }
    }
}