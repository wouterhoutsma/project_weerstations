import java.util.concurrent.ConcurrentLinkedQueue;

/**
 * Created by jelle on 24-1-2017.
 */
public class printer  implements Runnable {
    ConcurrentLinkedQueue  queue;
    public printer(ConcurrentLinkedQueue queue){
        this.queue = queue;
    }
    @Override
    public void run() {
        while (true) {
            if(!queue.isEmpty()) {
                System.out.println(queue.poll());
            }

        }
    }
}
