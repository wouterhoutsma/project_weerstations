import java.net.ServerSocket;
import java.net.Socket;
import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.Semaphore;

class leertaak2 {
    public static void main(String args[]){
        try {
            Semaphore sem = new Semaphore(1);
            ServerSocket socket = new ServerSocket(7789);
            ConcurrentLinkedQueue queue = new ConcurrentLinkedQueue();
            Thread t1 = new Thread(new printer(queue,sem));
            t1.start();
            Thread thread1;
            Socket sock;
            while(true){
                sock = socket.accept();
                thread1 = new Thread(new thread(queue, sock, sem));
                thread1.start();
           }
        } catch (Exception e) {
            System.out.println("PipeThread Exception: " + e);
        }
    }
}