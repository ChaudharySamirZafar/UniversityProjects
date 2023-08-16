
public interface LinearList {
	public boolean isEmpty(); // check is the list is empty
	public void add(Object obj); // add a object to the list
	public Object remove(int index); // remove object from a certain index
	public Object find(String name); // find a To do activity within the list by its name
	public boolean check(String name); // checks if the object is in the list
	public int size(); // returns the size of the list
}
