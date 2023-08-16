package Design_Pattern_Assignment.Science_Game;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;

public class Bullet extends GameObject {

	// angleOfBullet sets an angle for the bullet when the mouse is clicked
	Double angleOfBullet = 0d;
	// both variables help determine the gradient of the bullet
	// both variables take in each position of the cursor when the mouse is clicked
	double xMousePosition, yMousePosition;
	// a variable to judge the gradient and how the bullet will travel
	double gradient;
	// a variable for the BulletPool class to refer to, all unactive bullets are
	// taken out of the pool
	boolean active;

	/**
	 * @param x
	 * @param y
	 * @param graphicsContext
	 * @param root            
	 * constructor that takes the relevant graphical
	 * variables to change the graphics when a bullet is
	 * added
	 */
	public Bullet(double x, double y, GraphicsContext graphicsContext, Pane root) {
		super(x, y, graphicsContext, root);
		// Creating a new image variable and assinging it to the imageview variable type
		Image bullet = new Image(Bullet.class.getResource("bullet.png").toExternalForm(), 75, 75, false, false);
		image.setImage(bullet);

		// setting active to false as default
		active = false;

		// Setting the position of the bullet
		image.setLayoutX(x);
		image.setLayoutY(y);

	}

	/**
	 * a update method that constantly updates a bullets position when it enters the
	 * scene or resets the bullet if it leaves the scene
	 */
	@Override
	public void update() {

		// if the bullet is currently active then update its position
		if (active == true) {

			// checks if the Xposition of the cursor is greater then 0
			// then increment the x else decrement
			if (xMousePosition > 0) {
				image.setLayoutX(x += 3);
			} else if (xMousePosition < 0) {
				image.setLayoutX(x -= 3);
			}

			// if the bullet has left the screenview then call the reset method
			if (x > 1200 || x < 0)
				reset();
			if (y > 800 || y < 0)
				reset();
		}

		image.setLayoutY(y += gradient);
	}

	/**
	 * @param x
	 * @param y 
	 * converts the x and y position of the mouse cursor when clicked sets
	 * the bullet angle to the correct angle so its shoots in the right
	 * direction
	 */
	public void setAngle(double x, double y) {
		// TODO Auto-generated method stub

		// adds the imageView to the root so the user can see it
		root.getChildren().add(image);
		// The bullet has now been shot, so active is set to true
		active = true;

		// Calculates the angle of the bullet by converting the x and y
		// position of the mouse cursor to degrees
		angleOfBullet = Math.toDegrees(-Math.atan2(x, y)) - 90;

		xMousePosition = x;
		yMousePosition = y;

		// works out the gradient relative to the mouse x and y position
		gradient = (yMousePosition) / xMousePosition;
		if (xMousePosition < 0) {
			gradient = gradient * -1;
		}

		// sets the gradient relative to the x position
		gradient = gradient * 3;

		// rotates the bullet image to the correct angle
		image.setRotate(angleOfBullet);
	}

	/**
	 * @return active
	 */
	public boolean getActive() {
		return active;
	}

	/**
	 * resets all variables of the bullet
	 */
	public void reset() {

		// if the angle of the bullet is not 0, then execute the body
		if (this.angleOfBullet != 0) {
			// make active false so the pool can access it again
			active = false;
			// set x and y to default
			x = 600;
			y = 400;
			// remove the bullet from the graphics
			root.getChildren().remove(image);

		}
	}

}
