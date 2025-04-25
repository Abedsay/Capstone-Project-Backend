import java.io.*;
import java.net.*;
import java.util.*;

public class ChatServer {

    private static final Map<String, Socket> userMap = new HashMap<>();

    public static void main(String[] args) {
        int port = 8888;

        try (ServerSocket serverSocket = new ServerSocket(port)) {
            System.out.println("🔌 Server started on port " + port);

            while (true) {
                Socket clientSocket = serverSocket.accept();
                System.out.println("👤 New client connected: " + clientSocket.getInetAddress());

                new Thread(() -> handleClient(clientSocket)).start();
            }

        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    private static void handleClient(Socket socket) {
        String username = null;

        try (
            BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
            PrintWriter out = new PrintWriter(socket.getOutputStream(), true)
        ) {
            username = in.readLine();
            synchronized (userMap) {
                userMap.put(username, socket);
            }

            String message;
            while ((message = in.readLine()) != null) {
                System.out.println("📩 Message from " + username + ": " + message);

                String[] parts = message.split("\\|", 2);
                if (parts.length == 2) {
                    String recipientUsername = parts[0];
                    String msgBody = parts[1];

                    Socket recipientSocket;
                    synchronized (userMap) {
                        recipientSocket = userMap.get(recipientUsername);
                    }

                    if (recipientSocket != null && !recipientSocket.isClosed()) {
                        PrintWriter recipientOut = new PrintWriter(recipientSocket.getOutputStream(), true);
                        recipientOut.println(username + ": " + msgBody);
                    }
                } else {
                    out.println("Server: Invalid message format.");
                }
            }

        } catch (IOException e) {
            System.out.println("❌ Connection error with " + username);
        } finally {
            if (username != null) {
                synchronized (userMap) {
                    userMap.remove(username);
                }
            }
            try {
                socket.close();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }
}
