import java.io.*;
import java.net.Socket;
import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.Semaphore;

/**
 * Created by jelle on 24-1-2017.
 */
public class thread implements Runnable{
    ConcurrentLinkedQueue queue;
    Socket socket;
    Semaphore sem;
    public thread(ConcurrentLinkedQueue  queue, Socket socket, Semaphore sem){
        this.queue = queue;
        this.socket = socket;
        this.sem = sem;
    }
    @Override
    public synchronized void run() {
        try {
            StringBuffer buffer = new StringBuffer();
            BufferedReader bf = new BufferedReader(new InputStreamReader(socket.getInputStream()));
            String receiveResult;
            while((receiveResult = bf.readLine()) != null){
                buffer.append(receiveResult);
                buffer.append("\n");
                if(receiveResult.startsWith("</WEATHERDATA>")) {
                    try {
                        sem.acquire();
                        queue.add(buffer.toString());
                        sem.release();
                    } catch (InterruptedException eo) {
                    }
                }
            }
        }catch (IOException e){
        }
    }
}
