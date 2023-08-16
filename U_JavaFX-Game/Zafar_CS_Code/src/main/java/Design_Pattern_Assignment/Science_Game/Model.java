package Design_Pattern_Assignment.Science_Game;

import java.util.ArrayList;
import javafx.scene.canvas.GraphicsContext;
import javafx.scene.layout.Pane;
import javafx.scene.media.AudioClip;

public class Model {

	// a variable to keep track of what levels the user has completed
	public int level;

	// A variable to keep track if the player object has been created
	public boolean playerCreated;

	// a variable to see how many lives the user still has
	public int lives;

	// An arrayList of references of invader objects
	public ArrayList<Invader> invaders;

	// An arrayList of
	// a variable to identify if the game has been start
	boolean gameStarted;

	// a varaible to identify if the invaders game has started
	boolean invaderGameStarted;

	// a array to hold 4 questions for each level
	public String[] arrayOfQuestions = { "What Is The Biggest Planet In The Solar System?",
			"What Gas Do Plants Need To Grow?", "Which Scientist Discovered Gravity?",
			"Which is the main gas that makes up the Earth’s atmosphere?" };

	// 4 array to hold each questions possible answers
	private String[] question0Answer = { "Mercury", "Venus", "Earth", "Mars", "Jupiter", "Saturn", "Uranus",
			"Neptune" };
	private String[] question1Answer = { "Oxygen", "Hydrogen", "Neon", "Argon", "Krypton", "Xenon", "Radon",
			"Carbon Dioxide" };
	private String[] question2Answer = { "Isaac Newton", "Louis Pasteur", "Galileo", "Marie Curie", "Albert Einstein",
			"Charles Darwin", "Otto Hahn", "Nikola Tesla" };
	private String[] question3Answer = { "Nitrogen", "Oxygen", "Argon", "Carbon Dioxide", "Neon", "Helium", "Methane",
			"Xenon" };

	// A list of variables that hold the String value of the correct answers
	private String answer0 = "Jupiter";
	private String answer1 = "Carbon Dioxide";
	private String answer2 = "Isaac Newton";
	private String answer3 = "Nitrogen";

	// A reference to the gun made
	Gun gun;

	// A variable to keep track of the bullet pool
	BulletPool bulletPool;

	// Variables to track what levels are completed
	boolean level1Completed;
	boolean level2Completed;
	boolean level3Completed;
	boolean level4Completed;

	// A variable to keep a single player object throughout the whole game
	Player player;	
	
	
	//variables that store are of type AudioClip
	//sound is a shooting sound
	AudioClip shootingSound = new AudioClip(this.getClass().getResource("shoot.wav").toExternalForm());
	AudioClip invaderDying = new AudioClip(this.getClass().getResource("invaderkilled.wav").toExternalForm());
	AudioClip backgroundMusic = new AudioClip(this.getClass().getResource("BackgroundMusicV2.mp3").toExternalForm());

	public Model() {
		// TODO Auto-generated constructor stub
		level = 0;
		lives = 3;
		gameStarted = false;
		invaders = new ArrayList<Invader>();

		level1Completed = false;
		level2Completed = false;
		level3Completed = false;
		level4Completed = false;

		player = Singleton.getInstance();

		playerCreated = false;

	}

	/**
	 * this method is used to determine if the player is passing the level triggers
	 * on the map if the player is passing the level triggers then the main class
	 * will call the view class to bring up the shooting game once the game has been
	 * completed the player will spawn back where they was
	 * 
	 * @return number of Level
	 */
	public int checkPlayerPosition() {

		if (this.player.getY() >= 670 && (this.player.getX() > 169 && this.player.getX() <= 288)
				&& (level1Completed == false)) {
			return 1;
		} else if (this.player.getY() >= 670 && (this.player.getX() > 578 && this.player.getX() <= 694)
				&& (level2Completed == false)) {
			return 2;
		} else if ((this.player.getY() <= 575 && this.player.getY() >= 250)
				&& (this.player.getX() >= 386 && this.player.getX() <= 503) && (level3Completed == false)) {
			return 3;
		} else if ((this.player.getY() <= 112 && this.player.getY() >= 33)
				&& (this.player.getX() >= 935 && this.player.getX() <= 1030) && (level4Completed == false)) {
			return 4;
		}

		return 5;
	}

	/**
	 * this method checks if the player icon is hovering over the house which means
	 * they have finished
	 * 
	 * @return boolean
	 */
	public boolean checkWin() {

		// if the player is hovering over the house and then return true else return
		// false
		if ((this.player.getX() <= 1032 && this.player.getX() > 936) && this.player.getY() > 614) {
			return true;
		}

		return false;
	}

	/**
	 * this method calls the update method in all invader variables in the arrayList
	 * which moves them around in a circular motion
	 */
	public void updateInvaders() {
		for (int i = 0; i < invaders.size(); i++) {
			invaders.get(i).update();
		}
	}

	/**
	 * this method calls all update on bullets that are currently actively from the
	 * bullet pool
	 */
	public void updateBullets() {
		for (int i = 0; i < bulletPool.poolSize; i++) {
			Bullet bullet = bulletPool.getPool().get(i);
			if (bullet.active == true)
				bullet.update();
		}
	}

	/**
	 * @return String 
	 * depending upon the level the user is on this method returns an
	 * array of possible answers
	 */
	public String[] getPossibleAnswers() {
		if (level == 0)
			return question0Answer;
		else if (level == 1)
			return question1Answer;
		if (level == 2)
			return question2Answer;
		else if (level == 3)
			return question3Answer;

		return null;
	}

	/**
	 * @return String 
	 * depending upon the level the user is on this method returns a
	 * correct answer for the question
	 */
	public String getAnswers() {

		if (level == 0)
			return answer0;
		else if (level == 1)
			return answer1;
		if (level == 2)
			return answer2;
		else
			return answer3;
	}

	/**
	 * this method is dedicated to returning this class to its default state
	 */
	public void reset() {

		// resets the lives to 3
		this.lives = 3;
		// clears the invaders and sets the invaders game boolean check to false
		this.invaderGameStarted = false;
		this.invaders.clear();
		// sets the level to 0
		this.level = 0;

		// takes all bullets of the screen by resetting them
		resetAllBullets();

		// makes all boolean variables that check if a level is completed false
		level1Completed = false;
		level2Completed = false;
		level3Completed = false;
		level4Completed = false;

	}

	/**
	 * changes the boolean that represents completion of a level to true depending
	 * on what level the user is
	 */
	public void nextLevel() {

		if (level == 0)
			level1Completed = true;
		else if (level == 1)
			level2Completed = true;
		else if (level == 2)
			level3Completed = true;
		else if (level == 3)
			level4Completed = true;

		// resets all of the bullets
		resetAllBullets();

		// resets the lives back to 3
		this.lives = 3;
		// stops the invaders game
		this.invaderGameStarted = false;
		// clears the invaders
		this.invaders.clear();
		// advances the level
		this.level++;
	}

	/**
	 * @param graphicsContext
	 * @param root
	 * @param factory         
	 * sets the bullet pool up
	 */
	public void setBulletPool(GraphicsContext graphicsContext, Pane root, Factory factory) {
		bulletPool = new BulletPool(graphicsContext, root, factory);
	}

	/**
	 * @return ArrayList<BulletPool>
	 */
	public ArrayList<Bullet> retrievePool() {
		return bulletPool.getPool();
	}

	/**
	 * @return Bullet retrieves a bullet that is not active
	 */
	public Bullet getUnActive() {
		return bulletPool.borrowObject();
	}

	/**
	 * @return Bullet retrieves a bullet that is currently active
	 */
	public Bullet getActive() {
		return bulletPool.getActive();
	}

	/**
	 * resets all bullets taking them off the screen and resetting their positions
	 */
	public void resetAllBullets() {
		bulletPool.reset();
	}

	/**
	 * @param graphicsContext
	 * @param root            
	 * spawns the player in a specific position depending
	 * upon the position the player is
	 */
	public void SpawnPlayer(GraphicsContext graphicsContext, Pane root) {
		// TODO Auto-generated method stub
		if (level == 0) {
			player.spawnPlayer(50, 195, graphicsContext, root);
			playerCreated = true;
		}
		if (level == 1) {
			player.spawnPlayer(335, 721, graphicsContext, root);
			playerCreated = true;
		} else if (level == 2) {
			player.spawnPlayer(632, 632, graphicsContext, root);
			playerCreated = true;
		} else if (level == 3) {
			player.spawnPlayer(439, 217, graphicsContext, root);
			playerCreated = true;
		} else if (level == 4) {
			player.spawnPlayer(984, 141, graphicsContext, root);
			playerCreated = true;
		}

	}

}
