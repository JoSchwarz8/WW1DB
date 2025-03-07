import java.sql.Connection;
import java.sql.*;
import java.sql.SQLException;


//package com.example.ww1database;
/*
esta clase tiene que poder tomar los valores de la pagina html y
override los valores de la DB.
 */

import java.sql.PreparedStatement;

public class EditDAO {
    private String DB_URL = "jdbc:mysql://localhost:3306/ww1soldiers";
    private String DB_USER = "root";
    private String DB_PASS = " ";

    //if case where the input is empty...

    public boolean Edit(Edit edit) throws SQLException {
        //PreparedStatement preparedStatement = null;
        try (Connection con = DriverManager.getConnection(DB_URL,DB_USER, DB_PASS)){ //connection to the DB
            String sql = "UPDATE Bradford_Memorials SET surname=?, forename=?, regiment=?, unit=?, memorial=?, " +
                    "memorial_location=?, memorial_info=?, memorial_postcode=?, district=?, photo_available=? WHERE surname=?";
            PreparedStatement stmt = con.prepareStatement(sql.toString()); //sends the sql query to the DB

            stmt.setString(1, edit.getSurname());
            stmt.setString(2, edit.getForename());
            stmt.setString(3, edit.getRegiment());
            stmt.setString(4, edit.getUnit());
            stmt.setString(5, edit.getMemorial());
            stmt.setString(6, edit.getMemorial_location());
            stmt.setString(7, edit.getMemorial_info());
            stmt.setString(8, edit.getMemorial_postcode());
            stmt.setString(9, edit.getDistrict());
            stmt.setString(10, edit.getPhoto_available());
            stmt.setString(11, edit.getSurname());

        }catch (SQLException e){
            return false;
        }
        return true;
    }
}
