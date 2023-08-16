package Design_Pattern_Assignment.Science_Game;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;

public class Gun extends GameObject {

	public Gun(double x, double y, GraphicsContext graphicsContext, Pane root) {
		super(x, y, graphicsContext, root);
		// Makes a new image variable that represent a picture of gun
		Image gunImageTemplate = new Image(Gun.class.getResource("gun.png").toExternalForm(), 100, 100, false, false);
		// sets the image of the image view to the gun picture and sets the x and y of
		// the gun
		image.setImage(gunImageTemplate);
		image.setX(x);
		image.setY(y);
		// adding the gun imageview to the graphics
		root.getChildren().add(image);
	}

	/**
	 * @param rotation 
	 * rotates the gun image relative to the parameter given
	 */
	public void update(double rotation) {
		image.setRotate(rotation);
	}

}
