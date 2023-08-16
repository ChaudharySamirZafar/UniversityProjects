package Design_Pattern_Assignment.Science_Game;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.layout.Pane;

public class Factory implements FactoryIF {

	GraphicsContext graphicsContext;
	Pane root;

	/**
	 * @param graphicsContext
	 * @param root            
	 * takes in the graphicsContext and root for all
	 * gameObjects to update the graphical variables
	 */
	public Factory(GraphicsContext graphicsContext, Pane root) {
		super();
		this.root = root;
		this.graphicsContext = graphicsContext;
	}

	/**
	 * Creates a game object depending upon which string discrim is given
	 */
	@Override
	public GameObject createProduct(String objectName, double x, double y, String label) {
		if (objectName.equals("Invader")) {
			return new Invader(x, y, graphicsContext, root, label);
		} else if (objectName.equals("Gun")) {
			return new Gun(x, y, graphicsContext, root);
		} else if (objectName.equals("Bullet")) {
			return new Bullet(x, y, graphicsContext, root);
		}
		return null;
	}

}
