package Design_Pattern_Assignment.Science_Game;

import java.util.ArrayList;

import javafx.scene.canvas.GraphicsContext;
import javafx.scene.layout.Pane;

public class BulletPool {

	// the size of the bulletPool
	// Making it final as i want to keep it consistent
	final int poolSize = 25;

	// An arrayList for references to Bullet Objects
	private ArrayList<Bullet> bulletPool;

	/**
	 * @param graphicsContext
	 * @param root
	 * @param factory         
	 * adding bullets to the arraylist to set the pool up
	 */
	public BulletPool(GraphicsContext graphicsContext, Pane root, Factory factory) {
		bulletPool = new ArrayList<>();
		// TODO Auto-generated constructor stub
		for (int i = 0; i < poolSize; i++) {
			bulletPool.add((Bullet) factory.createProduct("Bullet", 600, 400, null));
		}
	}

	/**
	 * @return Bullet returns any bullets that are not currently active
	 */
	public Bullet borrowObject() {

		Bullet bullet = null;
		// for every bullet variable in the bullet pool
		for (Bullet bulletOfPool : bulletPool) {
			// if the bullet is not active then return that bullet and break out of the loop
			if (bulletOfPool.getActive() == false) {
				bullet = bulletOfPool;
				break;
			}
		}

		return bullet;

	}

	/**
	 * @return Bullet 
	 * returns the bullets which are active so they can keep getting
	 * updates
	 */
	public Bullet getActive() {

		Bullet bullet = null;
		// for every bullet variable in the bullet pool
		for (Bullet bulletOfPool : bulletPool) {
			// if the bullet is not acitve then return the bullet
			if (bulletOfPool.getActive() == true) {
				bullet = bulletOfPool;
			}
		}
		return bullet;
	}

	/**
	 * resets all bullets
	 */
	public void reset() {
		for (Bullet b : bulletPool) {
			b.reset();
		}
	}
	
	/**
	 * @return ArrayList<Bullet>
	 * returns the full pool of bullets
	 */
	public ArrayList<Bullet> getPool() {
		return bulletPool;
	}

}
