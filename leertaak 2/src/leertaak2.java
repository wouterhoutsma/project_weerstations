import java.net.ServerSocket;
import java.net.Socket;
import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.Semaphore;

class leertaak2 {
    public static void main(String args[]){
        try {
            ServerSocket socket = new ServerSocket(7789);
            ConcurrentLinkedQueue queue = new ConcurrentLinkedQueue();
            Thread t1 = new Thread(new printer(queue));
            t1.start();
            Thread thread1;
            Socket sock;
            Semaphore sem = new Semaphore(1);
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