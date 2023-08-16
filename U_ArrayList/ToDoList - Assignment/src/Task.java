public class Task {

	private String name;
	private String description;
	private String startDate;
	private String endDate;
	
	/**
	 * @param name
	 * @param description
	 * @param startDate
	 * @param endDate
	 * constructs a new task
	 */
	public Task(String name, String description, String startDate, String endDate) {
		this.name = name;
		this.description = description;
		this.startDate = startDate;
		this.endDate = endDate;
	}
	
	/**
	 * @return name
	 * returns the name of the task
	 */ 
	public String getName() {
		return name;
	}

	/**
	 * @param name
	 * sets the task name
	 */
	public void setName(String name) {
		this.name = name;
	}
	
	/**
	 * @return description
	 * returns the description of the task
	 */ 
	public String getDescription() {
		return description;
	}
	
	/**
	 * @param description 
	 * sets the task description 
	 */
	public void setDescription(String description) {
		this.description = description;
	}
	
	/**
	 * @return startDate
	 * returns the startDate of the task
	 */
	public String getStartDate() {
		return startDate;
	}
	
	/**
	 * @param endDate
	 * sets the endDate of the task
	 */
	public void setStartDate(String startDate) {
		this.startDate = startDate;
	}
	
	/**
	 * @return endDate
	 * returns the endDate of the task
	 */
	public String getEndDate() {
		return endDate;
	}
	
	/**
	 * @param endDate
	 * sets the endDate of the task
	 */
	public void setEndDate(String endDate) {
		this.endDate = endDate;
	}
	
	/**
	 * @return task details
	 */
	public String toString() {
		return "Name: "+ name +" Description: "+ description + " start date: " + startDate + " end date: " + endDate;

	}

}
