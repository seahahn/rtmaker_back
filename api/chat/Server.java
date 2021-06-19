package api.chat;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Vector;

public class Server {
    int port;
    ServerSocket serverSocket;
    Socket socket;
    Vector<ServerThread> serverThreads;
    ServerThread serverThread;

    public Server(int port){
        this.port = port;

        try{
            makeServer(port);
            serverThreads = new Vector<>();
            while(true){
                socket = catchSocket();
                serverThread = new ServerThread(this);
                serverThreads.add(serverThread);
                serverThread.start();
            }
        }catch (IOException ioException){
            ioException.printStackTrace();
        }
    }
    public void makeServer(int port) throws IOException {
        serverSocket = new ServerSocket(port);
    }
    public Socket catchSocket() throws IOException{
        socket = serverSocket.accept();

        return socket;
    }

    public static void main(String[] args) {
        new Server(33333);
    }
}