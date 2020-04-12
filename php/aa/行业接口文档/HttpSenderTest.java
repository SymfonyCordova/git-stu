import com.bcloud.msg.http.HttpSender;

public class HttpSenderTest {

	public static void main(String[] args) {
		String uri = "http://xxx.xxx.xxx.xx/msg/";//应用地址
		String account = "123";//账号
		String pswd = "123";//密码
		String mobiles = "13800210021,13800138000";//手机号码，多个号码使用","分割
		String content = "短信接口";//短信内容
		boolean needstatus = true;//是否需要状态报告，需要true，不需要false
		String product = "12345678";//产品ID
		String extno = "001";//扩展码
		try {
			String returnString = HttpSender.send(uri, account, pswd, mobiles, content, needstatus, product, extno);
			System.out.println(returnString);
			//TODO 处理返回值,参见HTTP协议文档
		} catch (Exception e) {
			//TODO 处理异常
			e.printStackTrace();
		}
		try {
			String returnString = HttpSender.batchSend(uri, account, pswd, mobiles, content, needstatus, product, extno);
			System.out.println(returnString);
			//TODO 处理返回值,参见HTTP协议文档
		} catch (Exception e) {
			//TODO 处理异常
			e.printStackTrace();
		}
	}
}
