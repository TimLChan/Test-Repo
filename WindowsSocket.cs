public class WinSocket : ISocketWrapper
{
    // Request these attributes in the Constructor
    public string Host { get { return this.host; } }
    public int Port { get { return this.port; } }
    public bool Secure { get { return this.secure; } }

    public bool Connected { get { return this.sock.Connected; } }

    public Task ConnectAsync()
    {
        this.sock.Connect(this.Host, this.Port);

        if (this.secure)
        {
            this.sslStream = new System.Net.Security.SslStream(this.sock.GetStream(), true, new RemoteCertificateValidationCallback(ValidateServerCertificate));
            this.sslStream.AuthenticateAsClient(this.Host);

            this.streamRead = new StreamReader(this.sslStream);
            this.streamWriter = new StreamWriter(this.sslStream);
        }
        else
        {
            this.streamRead = new StreamReader(this.sock.GetStream());
            this.streamWriter = new StreamWriter(this.sock.GetStream());
        }
        this.streamWriter.AutoFlush = true;

        return new Task(new Action(nope));
    }
    private bool ValidateServerCertificate(
  object sender,
  X509Certificate certificate,
  X509Chain chain,
  SslPolicyErrors sslPolicyErrors)
    {
        return true;
    }
    public void nope()
    { }

    public void Disconnect()
    {
        this.sock.Close();
        this.sock = new TcpClient();
        this.sock.Connect(this.Host, this.Port);
    }

    public StreamReader Reader { get { return this.streamRead; } }

    public StreamWriter Writer { get { return this.streamWriter; } }

    public WinSocket(string host, int port, bool secure)
    {
        this.secure = secure;
        this.sock = new TcpClient();
        this.host = host;
        this.port = port;
    }

    private TcpClient sock;
    private string host;
    private int port;
    private bool secure = false;

    //private NetworkStream ns;
    private System.Net.Security.SslStream sslStream;
    private StreamReader streamRead;
    private StreamWriter streamWriter;
}