package Design_Pattern_Assignment.Science_Game;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;
import javafx.scene.paint.ImagePattern;
import javafx.scene.shape.Circle;

public class Player extends GameObject {

	Circle playerIcon;
	
	static int playerCounter = 1;
	/**
	 * default constructor for when the player is made by the singleton class
	 */
	public Player() {
		super(0, 0, null, null);
	}

	/**
	 * @param x
	 * @param y
	 * @param graphicsContext
	 * @param root            
	 * a method to spawn a player on certain dimensions of
	 * the scene
	 */
	public void spawnPlayer(double x, double y, GraphicsContext graphicsContext, Pane root) {
		// Sets the x and y position of the player icon
		this.x = x;
		this.y = y;
		this.graphicsContext = graphicsContext;
		this.root = root;

		// creating a image variable that represents a picture of a player
		// making a playerIcon, filling it with the image and adding it to the scene
		Image image = new Image(Player.class.getResource("Player2.png").toExternalForm());
		playerIcon = new Circle(25);
		playerIcon.setLayoutX(x);
		playerIcon.setLayoutY(y);
		playerIcon.setFill(new ImagePattern(image));
		root.getChildren().add(playerIcon);

	}

	/**
	 * @param direction 
	 * a method that updates the playerIcons position depending
	 * upon the direction specified
	 */
	public void update(String direction) {

		if (direction.equals("UP")) {
			y -= 5;
		} else if (direction.equals("DOWN")) {
			y += 5;
		} else if (direction.equals("RIGHT")) {
			x += 5;
		} else {
			x -= 5;
		}

		playerIcon.setLayoutX(x);
		playerIcon.setLayoutY(y);

	}
}
