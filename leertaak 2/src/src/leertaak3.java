import java.net.ServerSocket;
import java.net.Socket;
import java.util.concurrent.ConcurrentLinkedQueue;

class leertaak3{
    public static void main(String args[]){
        try {
            ServerSocket socket = new ServerSocket(7789);
            ConcurrentLinkedQueue queue1 = new ConcurrentLinkedQueue();
            ConcurrentLinkedQueue queue2 = new ConcurrentLinkedQueue();
            Thread thread1 = new Thread(new parser(queue1,queue2)); // xml parser
            Thread thread2; // socket reader
            Thread thread3; //
            thread1.start();
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