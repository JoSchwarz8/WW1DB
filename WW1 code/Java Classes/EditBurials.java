import java.sql.SQLException;

public class EditBurials {
    private String Surname;
    private String Forename;
    private int DoB;
    private String Medals;
    private String Date_of_Death;
    private String Rank;
    private String Service_Number;
    private String Regiment;
    private String Battalion;
    private String Cemetery;
    private String Grave_Reference;
    private String Info;

    public EditBurials() throws SQLException{}

    public String getSurname() {
        return Surname;
    }

    public void setSurname(String surname) {
        Surname = surname;
    }

    public String getForename() {
        return Forename;
    }

    public void setForename(String forename) {
        Forename = forename;
    }

    public int getDoB() {
        return DoB;
    }

    public void setDoB(int doB) {
        DoB = doB;
    }

    public String getMedals() {
        return Medals;
    }

    public void setMedals(String medals) {
        Medals = medals;
    }

    public String getDate_of_Death() {
        return Date_of_Death;
    }

    public void setDate_of_Death(String date_of_Death) {
        Date_of_Death = date_of_Death;
    }

    public String getRank() {
        return Rank;
    }

    public void setRank(String rank) {
        Rank = rank;
    }

    public String getService_Number() {
        return Service_Number;
    }

    public void setService_Number(String service_Number) {
        Service_Number = service_Number;
    }

    public String getRegiment() {
        return Regiment;
    }

    public void setRegiment(String regiment) {
        Regiment = regiment;
    }

    public String getBattalion() {
        return Battalion;
    }

    public void setBattalion(String battalion) {
        Battalion = battalion;
    }

    public String getCemetery() {
        return Cemetery;
    }

    public void setCemetery(String cemetery) {
        Cemetery = cemetery;
    }

    public String getGrave_Reference() {
        return Grave_Reference;
    }

    public void setGrave_Reference(String grave_Reference) {
        Grave_Reference = grave_Reference;
    }

    public String getInfo() {
        return Info;
    }

    public void setInfo(String info) {
        Info = info;
    }

    EditBurials editBurials = new EditBurials();

    public EditBurials getEditBurials() {
        editBurials.setSurname(Surname);
        editBurials.setForename(Forename);
        editBurials.setDoB(DoB);
        editBurials.setMedals(Medals);
        editBurials.setDate_of_Death(Date_of_Death);
        editBurials.setRank(Rank);
        editBurials.setService_Number(Service_Number);
        editBurials.setRegiment(Regiment);
        editBurials.setBattalion(Battalion);
        editBurials.setCemetery(Cemetery);
        editBurials.setGrave_Reference(Grave_Reference);
        editBurials.setInfo(Info);

        return editBurials;
    }
    EditDAO editDAO = new EditDAO();
    boolean success = editDAO.EditBurials(editBurials);

}
