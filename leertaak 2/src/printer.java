import java.util.concurrent.ConcurrentLinkedQueue;
import java.util.concurrent.Semaphore;

/**
 * Created by jelle on 24-1-2017.
 */
public class printer  implements Runnable {
    ConcurrentLinkedQueue  queue;
    Semaphore sem;
    public printer(ConcurrentLinkedQueue queue, Semaphore sem){
        this.queue = queue;
        this.sem = sem;
    }
    @Override
    public synchronized void run() {
        while (true) {
            if(!queue.isEmpty()) {
                try{
                    sem.acquire();
                    System.out.println(queue.remove());
                   sem.release();
                }catch (InterruptedException eo){}
            }

        }
    }
}
