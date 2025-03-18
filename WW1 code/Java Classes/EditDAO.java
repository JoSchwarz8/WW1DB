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
    private String DB_URL = "jdbc:mysql://localhost:3000/ww1soldiers";
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

            int rowsAffected = stmt.executeUpdate();

        }catch (SQLException e){
            return false;
        }
        return true;
    }
    
    public boolean EditBurials(EditBurials editBurials) throws SQLException{
        try (Connection con = DriverManager.getConnection(DB_URL,DB_USER, DB_PASS)) { //connection to the DB
            String sql = "UPDATE Burials SET Surname=?, Forename=?, DoB=?, Medals=?, Date_of_Death=?, Rank=?, Service_Number=?, Regiment=?, Battalion=?, Cementary=?, Grave_Reference=?, Info=? WHERE Service_Number=?";
            PreparedStatement stmt = con.prepareStatement(sql.toString());
            stmt.setString(1, editBurials.getSurname());
            stmt.setString(2, editBurials.getForename());
            stmt.setInt(3, editBurials.getDoB());
            stmt.setString(4, editBurials.getMedals());
            stmt.setString(5, editBurials.getDate_of_Death());
            stmt.setString(6, editBurials.getRank());
            stmt.setString(7, editBurials.getService_Number());
            stmt.setString(8, editBurials.getRegiment());
            stmt.setString(9, editBurials.getBattalion());
            stmt.setString(10, editBurials.getCemetery());
            stmt.setString(11, editBurials.getGrave_Reference());
            stmt.setString(12, editBurials.getInfo());
        }catch (SQLException e) {
            return false;
        }
        return true;
    }


    public boolean EditBiography(EditBiography editBiography) {
            try (Connection con = DriverManager.getConnection(DB_URL,DB_USER, DB_PASS)){ //connection to the DB
                String sql = "UPDATE Biography_Information SET surname=?, forename=?, regiment=?, Service_Number=?, Biography_attachment WHERE Service_Number=?";
                PreparedStatement stmt = con.prepareStatement(sql.toString()); //sends the sql query to the DB
                stmt.setString(1, editBiography.getSurname());
                stmt.setString(2, editBiography.getForename());
                stmt.setString(3, editBiography.getRegiment());
                stmt.setInt(4, editBiography.getService_Number());
                stmt.setString(5, editBiography.getBiography_attachment());


            }catch (SQLException e){
                return false;
            }
            return true;
        }
}
