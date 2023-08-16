package Design_Pattern_Assignment.Science_Game;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;
import javafx.scene.paint.Color;
import javafx.scene.paint.ImagePattern;
import javafx.scene.shape.Circle;

public class Invader extends GameObject {

	// Static variables to calculate the point the invaders will spin around
	static double centerX = 600;
	static double centerY = 400;
	// variable to calculate the difference between invaders
	static double distance = 300;

	// Check if this invader has been hit before
	boolean hit;

	// sets the starting position for the invaders hence why its static
	static double rotation = 0;
	// specificRotation specifies fast the invaders need to spin
	double specificRotation;

	// A label that represents the invaders answer if it shot that answer will be
	// taken into account
	Label invaderAnswer;
	// A circle to fill with the invader image
	Circle invaderIcon;

	public Invader(double x, double y, GraphicsContext graphicsContext, Pane root, String label) {
		super(x, y, graphicsContext, root);

		// Creating a variable that represents an Invader picture
		Image invader = new Image(Invader.class.getResource("ubavder.jpg").toExternalForm(), 50, 50, false, false);
		// Making hit false by default
		hit = false;

		// Creates a new circle and fills it with the image of the invader and sets the
		// position
		invaderIcon = new Circle(25);
		invaderIcon.setLayoutX(x);
		invaderIcon.setLayoutY(y);
		invaderIcon.setFill(new ImagePattern(invader));

		// labels the invaders with a possible answer to the question being asked
		this.invaderAnswer = new Label(label);
		this.invaderAnswer.setTextFill(Color.WHITE);
		root.getChildren().addAll(this.invaderAnswer, this.invaderIcon);

		update();
		rotation++;
		specificRotation = rotation;

	}

	/**
	 * @return invader label
	 */
	public String getLabel() {
		return invaderAnswer.getText();
	}

	/**
	 * @return hit
	 */
	public Boolean getHit() {
		return hit;
	}

	/**
	 * a method that updates the invaders position when called frequently it moves
	 * the invader in a circle
	 */
	public void update() {

		// calculates the angle the invader needs to move
		double angle = 2 * specificRotation * Math.PI / 8;
		// calculates the x and y offset the invaders need to move regarding the angle
		double xOffset = distance * Math.cos(angle);
		double yOffset = distance * Math.sin(angle);

		// specificRotation specifies fast the invaders need to spin
		specificRotation += 0.005;

		// set the x and y to the calculated values
		x = centerX + xOffset;
		y = centerY + yOffset;

		// set the x and y of the invader and adjust the label relative to the invaders
		// dimensions
		invaderIcon.setLayoutX(x);
		invaderIcon.setLayoutY(y);

		invaderAnswer.setLayoutX(x + 5);
		invaderAnswer.setLayoutY(y + 50);
	}

	/**
	 * changes the appearance of the invader icon to a invader with a cross upon it
	 */
	public void wrongAnswer() {
		hit = true;
		Image image = new Image(Invader.class.getResource("inavderWrong.jpg").toExternalForm());
		this.invaderIcon.setFill(new ImagePattern(image));
	}

}
