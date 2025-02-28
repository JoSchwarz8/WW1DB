package com.example.lockdownfeature.demo;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import com.example.lockdownfeature.demo.Soldier;

public class SoldierDAO {
    // Update these with your actual database connection details
    private static final String DB_URL = "jdbc:mysql://localhost:3306/ww1soldiers";
    private static final String DB_USER = "root";
    private static final String DB_PASSWORD = "password";

    /**
     * Searches for soldiers based on the given parameters.
     * Any parameter left null or empty will be ignored.
     *
     * @param surname   The surname to search for.
     * @param forename  The forename to search for.
     * @param regiment  The regiment to search for (optional, e.g., from BradSurrTowns.html).
     * @param cemetery  The cemetery to search for (optional, e.g., from BurBrad.html).
     * @return A list of matching Soldier objects.
     */
    public static List<Soldier> searchSoldiers(String surname, String forename, String regiment, String cemetery) {
        List<Soldier> soldiers = new ArrayList<>();
        // Build the SQL query dynamically. "WHERE 1=1" simplifies appending conditions.
        StringBuilder sql = new StringBuilder("SELECT * FROM Soldiers WHERE 1=1");

        if (surname != null && !surname.trim().isEmpty()) {
            sql.append(" AND surname LIKE ?");
        }
        if (forename != null && !forename.trim().isEmpty()) {
            sql.append(" AND forename LIKE ?");
        }
        if (regiment != null && !regiment.trim().isEmpty()) {
            sql.append(" AND regiment LIKE ?");
        }
        if (cemetery != null && !cemetery.trim().isEmpty()) {
            sql.append(" AND cemetery LIKE ?");
        }

        try (Connection conn = DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
             PreparedStatement stmt = conn.prepareStatement(sql.toString())) {

            int paramIndex = 1;
            if (surname != null && !surname.trim().isEmpty()) {
                stmt.setString(paramIndex++, "%" + surname + "%");
            }
            if (forename != null && !forename.trim().isEmpty()) {
                stmt.setString(paramIndex++, "%" + forename + "%");
            }
            if (regiment != null && !regiment.trim().isEmpty()) {
                stmt.setString(paramIndex++, "%" + regiment + "%");
            }
            if (cemetery != null && !cemetery.trim().isEmpty()) {
                stmt.setString(paramIndex++, "%" + cemetery + "%");
            }

            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                Soldier soldier = new Soldier();
                soldier.setId(rs.getInt("id"));
                soldier.setSurname(rs.getString("surname"));
                soldier.setForename(rs.getString("forename"));
                soldier.setRegiment(rs.getString("regiment"));
                soldier.setCemetery(rs.getString("cemetery"));
                soldiers.add(soldier);
            }
        } catch (SQLException e) {
            e.printStackTrace();
            // In a production system, proper error handling should be implemented.
        }

        return soldiers;
    }
}
