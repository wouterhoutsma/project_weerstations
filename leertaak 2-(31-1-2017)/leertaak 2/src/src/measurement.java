/**
 * Created by jelle on 25-1-2017.
 */
package src;
public class measurement {
    int number;
    long date;
    double temp;
    double wdsp;

    public measurement(int number, long date, double temp, double wdsp){
        this.number = number;
        this.date = date;
        this.temp = temp;
        this.wdsp = wdsp;
    }
    public void print(measurement mes){
        System.out.println(" number " + mes.number + " \n date " + mes.date + "\n tempratuur " + mes.temp + "\n wdsp " + mes.wdsp );
    }

    @Override
    public String toString() {
        return "INSERT INTO measurement (STN, TIMEDATE, TEMP, WNSP) VALUES ("+this.number+ ","+ this.date+","+this.temp+","+this.wdsp+")";
    }
}
