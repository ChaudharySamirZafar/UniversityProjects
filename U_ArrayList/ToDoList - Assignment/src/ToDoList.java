
public class ToDoList {

	private ArrayList<Task> toDoList; //toDoList which stores an arrayList of tasks

	public ToDoList() {
		toDoList = new ArrayList<Task>();
	}
	
	/**
	 * @param name
	 * @param description
	 * @param startDate
	 * @param endDate
	 * adds a task to the toDoList
	 */
	public void add(String name, String description, String startDate, String endDate) {
		toDoList.add(new Task(name, description, startDate, endDate));
	}
	
	/**
	 * shows all of the current tasks in the list
	 */
	public void showAllTasks() {
		if (toDoList.size() > 0) {
			for (int i = 0; i < toDoList.size(); i++) {
				Task t = (Task) toDoList.getElement(i); //explicity casts the elements to a task object
				System.out.println("Position: " + i + " " + t.toString());
			}
		} else {
			System.out.println("No tasks in the list");
		}
	}
	
	/**
	 * @param index
	 * takes an index and removes that position from the list
	 */
	public void removeTask(int index) {
			toDoList.remove(index);
	}
	
	/**
	 * @param name
	 * finds a task by its name and notifies the user of its position and details
	 */
	public void findTaskByName(String name) {
		toDoList.find(name);
	}
	
	/**
	 * @return toDoList size
	 */
	public int getSize() {
		return toDoList.size();
	}
	
	/**
	 * 
	 * @param name
	 * find a task name that matches the name given and states if was found
	 * if it wasnt found the user will be notified
	 */
	public void checkIfTaskExists(String name) {
		toDoList.check(name);
	}

}
