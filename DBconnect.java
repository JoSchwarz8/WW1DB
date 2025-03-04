import java.sql.DriverManager;
import java.sql.SQLException;

//TIP To <b>Run</b> code, press <shortcut actionId="Run"/> or
// click the <icon src="AllIcons.Actions.Execute"/> icon in the gutter.
public class Main {
    private static final String url = "jdbc:mysql://localhost:3000/WW1";
    private static final String user = "root";;
    private static final String password = "";
    public static void main(String[] args) throws SQLException {
        try(final var connection= DriverManager.getConnection(url,user,password);
            final var statement = connection.createStatement()){
            final var Query= statement.executeQuery(""); // Enter SQL query
        }
    }
}