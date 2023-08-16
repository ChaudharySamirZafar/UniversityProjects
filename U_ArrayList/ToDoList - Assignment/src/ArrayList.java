import java.lang.IllegalArgumentException;
import java.lang.IndexOutOfBoundsException;
import java.util.Scanner;

public class ArrayList<E> implements LinearList {

	private Object[] elementArray;
	private int size;

	/**
	 * creates a list with inital capacity
	 * 
	 * @throws IllegalArgumentException when initialCapacity < 1
	 */
	public ArrayList(int initalCapacity) {
		if (initalCapacity < 1) // if the capacity is lower then 1 then throw an error
			throw new IllegalArgumentException("capacity must be >= 1");
		elementArray = new Object[initalCapacity];
		size = initalCapacity;
	}

	/**
	 * creates a arrayList with an initial capacity of 1
	 */
	public ArrayList() {
		elementArray = new Object[0];
		size = 0;
	}

	/**
	 * @return boolean checks if the size of the elementList is 0 if the size is 0
	 *         return true
	 */
	public boolean isEmpty() {
		return size == 0;
	}

	/**
	 * @param takes a element to add to the list adds a element to the list
	 */
	public void add(Object obj) {
		int nullElements = checkAllEmpty(); // calls a method which checks if any spaces are null
		if (nullElements < elementArray.length) { // if their is a null element, assigns the new element to that
													// position
			replace(nullElements, obj);
		} else {
			Object[] newArray = new Object[elementArray.length + 1 ]; // creates a new array with size one larger then
																		// current
			System.arraycopy(elementArray, 0, newArray, 0, elementArray.length);
			elementArray = newArray;
			elementArray[elementArray.length - 1] = obj; // assigns the new element to the end of the new array
			size++;
		}
	}

	/**
	 * checks if their is any null values in the existing list returns the list
	 * position to the other method so the method can fill that null gap
	 */
	private int checkAllEmpty() {
		int i;
		for (i = 0; i < size; i++) {
			if (elementArray[i] == null) // if the element in the array is null. Break out of the loop and return the
											// element index
				break;
			else {
				continue;
			}
		}
		return i;
	}

	/**
	 * @param i
	 * @param obj takes an position and a obj places the obj at the specific
	 *            position
	 */
	private void replace(int i, Object obj) {
		elementArray[i] = obj;
	}

	/**
	 * @param index of element that needs to be removed checks if the index is valid
	 *              and removes the element
	 */
	public Object remove(int index) {
		
		index = checkIndex(index); // checks if index is valid, call other method#

		Object removedElement = elementArray[index]; // Assigns the element you want to remove to a variable
		for (int i = index; i < size - 1; i++) // moves each elements to the left, removing the index
		{
			elementArray[i] = elementArray[i + 1];
		}

		elementArray[size - 1] = null; // assigns the end of the list to a null value
		return removedElement;

	}

	/**
	 * @throws indexOutOfBoundsException when the index is less then 0 or greater
	 *                                   then size - 1 and asks the user to repeat
	 *                                   the input
	 * 
	 */
	public int checkIndex(int index) {
		try {
			Object obj = elementArray[index];
			return index;
		} catch (IndexOutOfBoundsException e) {
			System.out.println("Index is not in bounds, please type another number");
			Scanner scan = new Scanner(System.in);
			int a = scan.nextInt();
			return checkIndex(a); // recursive call to get the right input from the user
		}
	}

	/**
	 * @param name of task go through all the tasks and matches the task that
	 *             matches the name given in params
	 */
	public Object find(String name) {

		Task t = null;
		Object currentObj = null;
		int i = -1;
		boolean found = false;

		for (Object o : elementArray) {
			i++;
			if (o instanceof Task) {
				t = (Task) o;
				if (t.getName().equals(name)) { // if the name of the task equals the name given then identify the task
					System.out.println("Task: " + name + " was found at position : " + i);
					currentObj = o;
					found = true;
					break;
				}
			}
		}
		if (found == false) {
			System.out.println("Task not found");
			return null;
		} else {
			return currentObj;
		}

	}
	
	/**
	 * @param task name
	 * takes a task name and returns a boolean depending on wether it exists or not
	 */
	public boolean check(String name) {
		Task t = null;
		int i = -1;
		boolean found = false;

		for (Object o : elementArray) {
			i++;
			if (o instanceof Task) //if the object is an instance of the task then it will execute the body 
				{
				t = (Task) o; //explictility casts object to task
				if (t.getName().equalsIgnoreCase(name)) {
					found = true;
					break;
				}
			}
		}

		if (found == false) {
			System.out.println("Task was not found");
			return found;
		} else {
			System.out.println("Task was found");
			return found;
		}
	}

	/**
	 * @return size returns the size of the list
	 */
	public int size() {
		int count = 0;
		for (Object o : elementArray) //gets every object in the array 
		{
			if (o != null) //if object isnt null adds to the counter
			{
				count++;
			}
		}
		return count;
	}

	/**
	 * @param index
	 * @return the element at the index
	 */
	public Object getElement(int index) {
		checkIndex(index);
		return elementArray[index];
	}
}
