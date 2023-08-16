import java.util.InputMismatchException;
import java.util.Scanner;

public class UserInterface {

	private ToDoList toDoList;
	private boolean exit;

	public static void main(String[] args) {

		UserInterface ui = new UserInterface();
	}

	public UserInterface() {
		toDoList = new ToDoList();
		printMenu(); //prints the menu of the available options
		exit = false; //initalises exit as false
		while (exit != true) //if exit isnt not true keep taking the user input 
		{
			userInput(); 
		}

	}

	/**
	 * prints the user menu for the user to see their input
	 */
	public void printMenu() {
		System.out.println("#####################");
		System.out.println("Press 1 to view all tasks");
		System.out.println("Press 2 to add an task");
		System.out.println("Press 3 to remove a task");
		System.out.println("Press 4 to check if a task exists");
		System.out.println("Press 5 to find a task by its name");
		System.out.println("Press 6 to count the amount of tasks");
		System.out.println("Press 7 to Exit");
		System.out.println("#####################");
	}

	/**
	 * gets user input from a scanner
	 * according to the input a method is called
	 */
	public void userInput() {
		Scanner scanner = new Scanner(System.in);

		try {
			int action = scanner.nextInt();
			switch (action) {
			case 1:
				showAllTasks();
				break;
			case 2:
				addItemToList();
				break;
			case 3:
				removeTask();
				break;
			case 4:
				checkIfTaskExists();
				break;
			case 5:
				findIfTaskExists();
				break;
			case 6:
				checkSize();
				break;
			case 7:
				exit();
				break;
			default: //if no cases match the code after the default clause and between the break clause will be executed
				System.err.println("Invalid input, please try again. Enter numbers between and equal to 1 and 7");
				userInput();
				break;
			}
		} catch (InputMismatchException err) //if the user inputs something other then numerical values 
		{
			System.err.println("Please enter numbers only");
			userInput();
		}
	}

	/**
	 * terminates the application
	 */
	public void exit() {
		System.out.println("You have now exited the program. GoodBye");
		exit = true;
	}
	
	/*
	 * shows the user all of the current tasks in their list
	 */
	public void showAllTasks() {
		toDoList.showAllTasks();
		System.out.println(" ");
		printMenu();
	}
	
	/**
	 * allows a user to add to their list with their input
	 */
	public void addItemToList() {
		Scanner scanner = new Scanner(System.in);
		System.out.println("Please give a name for the task you want to add");
		String nameOfTask = scanner.nextLine();
		System.out.println("Please give a description for the task you want to do ");
		String description = scanner.nextLine();
		System.out.println("Please enter a startDate for the task you want to do, please use the format DD/MN/YYYY");
		String startDate = scanner.nextLine();
		System.out.println("Please enter a endDate for the task you want to do, please use the format DD/MN/YYYY");
		String endDate = scanner.nextLine();
		System.out.println("Your task will look like, Name: " + nameOfTask + " Description: " + description
				+ " startDate: " + startDate + " endDate: " + endDate);
		System.out.println("If you are sure you want to add this task, press 1.");
		System.out.println("If you are sure you DO NOT want to add this task, press 2.");

		int confirm = scanner.nextInt();

		if (confirm == 1) {
			System.out.println("Your task was added");
			toDoList.add(nameOfTask, description, startDate, endDate);
			System.out.println(" ");
			printMenu();
		} else {
			System.out.println("Your task was not added");
			System.out.println(" ");
			printMenu();
		}

	}


	/**
	 * allows a user to remove a task from their current list
	 */
	public void removeTask() {
		if (toDoList.getSize() > 0) {
			Scanner scanner = new Scanner(System.in);
			System.out.println("Here are your existing task, pick the index of which youd like to remove");
			toDoList.showAllTasks();
			int removeElement = scanner.nextInt();
			toDoList.removeTask(removeElement);
			System.out.println("Here is your updated task list");
			toDoList.showAllTasks();
			System.out.println(" ");
			printMenu();
		} else {
			System.out.println("You have no tasks in your list currently.");
			System.out.println(" ");
			printMenu();
		}
	}
	
	/**
	 * lets a user see if a task exists from tehir list
	 * a name is scanned from scanner 
	 * if their are no tasks the user will be notified 
	 */
	public void checkIfTaskExists() {
		if (toDoList.getSize() > 0) {
			Scanner scanner = new Scanner(System.in);
			System.out.println("Please specify the Task NAME you want to check");
			String element = scanner.nextLine();
			toDoList.checkIfTaskExists(element);
			System.out.println(" ");
			printMenu();
		} else {
			System.out.println("You have no tasks in your list currently.");
			System.out.println(" ");
			printMenu();
		}
	}	

	/**
	 * finds a task from the list and returns it to the user 
	 * the user enters a name and the search happens
	 * if their is no tasks in the list then the user will be notified
	 */
	public void findIfTaskExists() {
		if (toDoList.getSize() > 0) {
			Scanner scanner = new Scanner(System.in);
			System.out.println("Please specify the Task NAME you want to find");
			String element = scanner.nextLine();
			toDoList.findTaskByName(element);
			System.out.println(" ");
			printMenu();
		} else {
			System.out.println("You have no tasks in your list currently.");
			System.out.println(" ");
			printMenu();
		}
	}
	
	
	/**
	 * returns the size of the toDoList
	 */
	public void checkSize() {
		System.out.println(toDoList.getSize());
		System.out.println(" ");
		printMenu();
	}

}
