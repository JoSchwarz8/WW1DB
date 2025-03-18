import java.sql.SQLException;

public class EditBiography {
    private String surname;
    private String forname;
    private String regiment;
    private int Service_Number;
    private String Biography_attachment;

    public EditBiography() throws SQLException {
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

    public int getService_Number() {
        return Service_Number;
    }

    public void setService_Number(int service_Number) {
        Service_Number = service_Number;
    }

    public String getBiography_attachment() {
        return Biography_attachment;
    }

    public void setBiography_attachment(String biography_attachment) {
        Biography_attachment = biography_attachment;
    }

    //public void HTML(Http)
    //de donde saca el soldier service number?
    //int id = Integer.parseInt(request.getParameter("id"));
    EditBiography editBiography = new EditBiography();

    public EditBiography getEditBiography(){
        editBiography.setSurname(surname);
        editBiography.setForname(forname);
        editBiography.setRegiment(regiment);
        editBiography.setService_Number(Service_Number);
        editBiography.setBiography_attachment(Biography_attachment);
        return editBiography;
    }



    EditDAO editDAO = new EditDAO();
    boolean success = editDAO.EditBiography(editBiography);


}
