package api.chat;

import java.io.DataInputStream;
import java.io.DataOutputStream;
import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Vector;

public class ServerThread extends Thread{
    ServerSocket serverSocket;
    Socket socket;
    DataInputStream inputStream;
    DataOutputStream outputStream;
    Vector<ServerThread> serverThreads;
    String chatRoomId;

    public ServerThread(Server server){
        this.serverSocket = server.serverSocket;
        socket = server.socket;
        serverThreads = server.serverThreads;
        try{
            inputStream = connectInputStream();
            outputStream = conncetOutputStream();

            this.chatRoomId = receiveChatRoomId();
        }catch (Exception e){
            e.printStackTrace();
        }
    }
    public DataInputStream connectInputStream() throws IOException {
        inputStream = new DataInputStream(socket.getInputStream());

        return inputStream;
    }
    public DataOutputStream conncetOutputStream() throws IOException {
        outputStream = new DataOutputStream(socket.getOutputStream());

        return outputStream;
    }
    public String receiveChatRoomId() throws IOException {
        String id = inputStream.readUTF();

        return id;
    }
    public void sendMessageToClient(String msg) throws IOException {
        outputStream.writeUTF(msg);
    }
    public String receiveMessageFromClient() throws IOException {
        String msg = inputStream.readUTF();

        return msg;
    }
    public void broadCast(String msg) throws IOException {
        for(ServerThread serverThread : serverThreads){
            if(serverThread.chatRoomId.equals(this.chatRoomId)) {
                serverThread.sendMessageToClient(msg);
            }
        }
    }

    @Override
    public void run() {
        try{
            while(true){
                String msg = receiveMessageFromClient();
                broadCast(msg);
            }
        }catch (Exception e){
            e.printStackTrace();
        } finally {
            serverThreads.remove(this);
            try{
                socket.close();
            }catch (IOException ioException){
                ioException.printStackTrace();
            }
        }
    }
}
