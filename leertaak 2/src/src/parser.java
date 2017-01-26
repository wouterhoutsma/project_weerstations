import javax.xml.parsers.*;
import org.xml.sax.InputSource;
import org.w3c.dom.*;
import java.io.IOException;
import java.io.StringReader;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.concurrent.ConcurrentLinkedQueue;
/**
 * Created by jelle on 24-1-2017.
 */
public class parser  implements Runnable {
    ConcurrentLinkedQueue queue1;
    ConcurrentLinkedQueue queue2;

    public parser(ConcurrentLinkedQueue queue1, ConcurrentLinkedQueue queue2) {
        this.queue1 = queue1;
        this.queue2 = queue2;
    }

    @Override
    public synchronized void run() {
        try {
            DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();
            DocumentBuilder db = dbf.newDocumentBuilder();
            Element element;
            InputSource is = new InputSource();
            NodeList nodes;
            measurement measurement;
            SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd hh:mm:ss");
            while (true) {
                if (!queue1.isEmpty()) {
                is.setCharacterStream(new StringReader(queue1.remove().toString()));
                nodes = db.parse(is).getElementsByTagName("MEASUREMENT");
                    for (int i = 0; i < nodes.getLength(); i++){
                        element = (Element) nodes.item(i);
                            if(!element.getElementsByTagName("STN").item(0).getTextContent().isEmpty()
                           && !element.getElementsByTagName("DATE").item(0).getTextContent().isEmpty()
                           && !element.getElementsByTagName("TIME").item(0).getTextContent().isEmpty()){
                            double temp = 000000;
                            double wdsp = 000000;
                            if(!element.getElementsByTagName("TEMP").item(0).getTextContent().isEmpty()){
                                temp = Double.parseDouble(element.getElementsByTagName("TEMP").item(0).getTextContent());
                            }
                            if(!element.getElementsByTagName("WDSP").item(0).getTextContent().isEmpty()) {
                                wdsp = Double.parseDouble(element.getElementsByTagName("WDSP").item(0).getTextContent());
                            }
                            measurement = new measurement(
                            Integer.parseInt(element.getElementsByTagName("STN").item(0).getTextContent()),
                            dateFormat.parse(element.getElementsByTagName("DATE").item(0).getTextContent()
                            + " " + element.getElementsByTagName("TIME").item(0).getTextContent()).getTime(),
                            temp, wdsp
                            );
                            queue2.add(measurement);
                            measurement.print(measurement);
                        }

                    }
                }
            }
        }catch (ParserConfigurationException | org.xml.sax.SAXException | IOException | ParseException e){}
    }
}

