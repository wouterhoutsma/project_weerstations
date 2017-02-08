package src;

import java.io.*;
import java.net.Socket;
import java.util.Queue;
import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.LinkedBlockingQueue;

/**
 * Created by jelle on 24-1-2017.
 */
public class socketReader implements Runnable{
    ConcurrentLinkedQueue queue;
    Socket socket;
    public socketReader(ConcurrentLinkedQueue queue, Socket socket){
        this.queue = queue;
        this.socket = socket;
    }
    @Override
    public synchronized void run() {
        StringBuffer buffer = new StringBuffer();
        try {

            BufferedReader bf = new BufferedReader(new InputStreamReader(socket.getInputStream()));
            String receiveResult;
            while((receiveResult = bf.readLine()) != null){
                buffer.append(receiveResult);
                buffer.append("\n");
                if(receiveResult.indexOf("</WEA")>-1) {
                        queue.add(buffer.toString());
                        buffer.delete(0, buffer.length());
                }
            }

        }catch (IOException  e){System.out.println(e);}
    }
}
