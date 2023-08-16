package Design_Pattern_Assignment.Science_Game;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.Pane;
import javafx.scene.shape.Circle;

public class GameObject {

	// A image view variable for the subclasses to use
	protected ImageView image;
	// defines the x and y of the image
	protected double x, y;
	protected GraphicsContext graphicsContext;
	protected Pane root;

	public GameObject(double x, double y, GraphicsContext graphicsContext, Pane root) {
		// TODO Auto-generated constructor stub
		super();
		this.root = root;
		this.x = x;
		this.y = y;
		image = new ImageView();
		this.graphicsContext = graphicsContext;

	}

	/**
	 * updates the graphics context if the image is not null a method to be called
	 * frequently in a timer
	 */
	public void update() {
		if (image != null) {
			// Hard coded the size of the images to be 50, so no images are too big
			graphicsContext.drawImage(image.getImage(), x, y, 50, 50);
		}
	}

	/**
	 * @return x position of image
	 */
	public double getX() {
		return x;
	}

	/**
	 * @return y position of image
	 */
	public double getY() {
		return y;
	}

}
