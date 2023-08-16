package Design_Pattern_Assignment.Science_Game;

public class Singleton {

	// an instance of a player object
	// calls the default constructor
	// lets the model update the player variable depending upon what level the user
	// is on
	private static Player instance = null;

	/**
	 * a private constructor for singleton
	 */
	private Singleton() {
		// TODO Auto-generated constructor stub
		instance = new Player();
	}

	/**
	 * @return Player
	 */
	public static Player getInstance() {
		
		if (instance == null) {
			new Singleton();
		}
		
			return instance;
	}

}
