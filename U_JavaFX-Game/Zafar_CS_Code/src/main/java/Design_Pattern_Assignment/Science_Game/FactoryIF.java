package Design_Pattern_Assignment.Science_Game;

public interface FactoryIF {
	//A method that creates specific GameObject variables depending on a string given
	GameObject createProduct(String objectName, double x, double y, String label);
}