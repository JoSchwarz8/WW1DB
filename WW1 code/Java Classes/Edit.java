import java.sql.SQLException;
//Edit example with memorial database

public class Edit {

    private String surname;
    private String forname;
    private String regiment;
    private String unit;
    private String memorial;
    private String memorial_location;
    private String memorial_info;
    private String memorial_postcode;
    private String district;
    private String photo_available;

    public Edit() throws SQLException {
    }


    public String getSurname(){
        return surname;
    }
    public void setSurname(String surname){
        this.surname =surname;
    }

    public String getForename(){
        return forname;
    }
    public void setForname(String forname){
        this.forname =forname;
    }

    public String getRegiment(){
        return regiment;
    }
    public void setRegiment(String regiment){
        this.regiment =regiment;
    }

    public String getUnit(){
        return unit;
    }
    public void setUnit(String unit){
        this.unit =unit;
    }

    public String getMemorial(){
        return memorial;
    }
    public void setMemorial(String memorial){
        this.memorial =memorial;
    }

    public String getMemorial_location(){
        return memorial_location;
    }
    public void setMemorial_location(String memorial_location){
        this.memorial_location =memorial_location;
    }

    public String getMemorial_info(){
        return memorial_info;
    }
    public void setMemorial_info(String memorial_info){
        this.memorial_info =memorial_info;
    }

    public String getMemorial_postcode(){
        return memorial_postcode;
    }
    public void setMemorial_postcode(String memorial_postcode){
        this.memorial_postcode =memorial_postcode;
    }

    public String getDistrict(){
        return district;
    }
    public void setDistrict(String district){
        this.district =district;
    }

    public String getPhoto_available(){
        return photo_available;
    }
    public void setPhoto_available(String photo_available){
        this.photo_available =photo_available;
    }

    //public void HTML(Http)
        //de donde saca el soldier service number?
    //int id = Integer.parseInt(request.getParameter("id"));
    Edit edit = new Edit();

    public Edit getEdit() {
        Edit edit = new Edit();
        
        edit.setSurname(surname);
        edit.setForname(forname);
        edit.setRegiment(regiment);
        edit.setUnit(unit);
        edit.setMemorial(memorial);
        edit.setMemorial_info(memorial_info);
        edit.setMemorial_location(memorial_location);
        edit.setDistrict(district);
        edit.setMemorial_postcode(memorial_postcode);
        edit.setPhoto_available(photo_available);
        return edit;
    }

    EditDAO editDAO = new EditDAO();
    boolean success = editDAO.Edit(edit);

    if(success){
        System.out.println("Database row updated successfully");
}else{
    System.out.println("Failed to update database");
}


}
