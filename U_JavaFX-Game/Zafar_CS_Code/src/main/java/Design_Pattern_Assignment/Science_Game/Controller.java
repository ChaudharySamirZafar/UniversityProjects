package Design_Pattern_Assignment.Science_Game;

import javafx.animation.AnimationTimer;
import javafx.event.Event;
import javafx.event.EventHandler;
import javafx.scene.input.KeyCode;
import javafx.scene.input.KeyEvent;
import javafx.scene.input.MouseEvent;
import javafx.scene.media.AudioClip;


public class Controller implements EventHandler {

	Model model;
	View view;
	
	// A variable to allow the user to see the instructions for a period of time
	// before the game starts
	int introductionCounter = 0;

	// A variable to see if this is the users first start to the game and if so show
	// the instructions
	boolean firstStart = true;
	
	// A timer for when the regular game is being played
	AnimationTimer regularGameTimer = new AnimationTimer() {
		@Override
		public void handle(long arg0) {
		
			// if the introductionCounter is 0 and its the user firstStart then
			// sets the view to an introduction scene
			// else set the game up
			if (introductionCounter == 0 && firstStart == true) {
				view.setInstruction();
			} else if (introductionCounter == 500) {
				firstStart = false;
				view.setGame(0);
			}

			introductionCounter++;

			// if the game has started execute the body
			if (model.gameStarted == true) {
				
				if(model.backgroundMusic.isPlaying() == false) {	
					model.backgroundMusic.play();
					System.out.println(model.backgroundMusic.getVolume());
				}
				
				// if the player icon has not be created then spawn the player in graphically
				if (model.playerCreated == false) {
					model.SpawnPlayer(view.graphicsContext, view.root);
				}

				// if a key is pressed then refer to the keyboardHandler
				view.scene.setOnKeyPressed(keyboardHandler);

				// if the method returns less 5 and the invaders game is not being played then
				// set the invaders game up
				if (model.checkPlayerPosition() < 5 && model.invaderGameStarted == false) {
					view.setInvadersGame();

					// stoping this timer and starting the invaders timer
					this.stop();
					invaderGameTimer.start();

				}
			}

			// if level4 boolean is true then execute the body
			if (model.level4Completed == true) {
				// if the model method checkWin equals true then set the view to a winning scene
				if (model.checkWin() == true) {
					view.displayWin();
				}
			}

		}
	};

	// A timer for when the invaders game is being played
	AnimationTimer invaderGameTimer = new AnimationTimer() {
		@Override
		public void handle(long arg0) {
			// sets the playerCreated to false so the player can be spawned again
			// when the regular game is started
			model.playerCreated = false;
			
			if(model.backgroundMusic.isPlaying() == false) {	
				model.backgroundMusic.play();
				System.out.println(model.backgroundMusic.getVolume());
			}
		
			// if the user has lost all lives excute the body
			if (model.lives == 0) {
				// reseting all bullets from the pool
				model.resetAllBullets();
				// setting the view to the starting level
				view.setGame(0);
				// resets the model class. sets variables back to default
				model.reset();
				// stop this timer and starts the regular game one
				invaderGameTimer.stop();
				regularGameTimer.start();
			}

			// updating the invaders so they can constantly spin
			model.updateInvaders();

			// if the user has shots any bullets then update their position
			if (model.bulletPool != null) {
				model.updateBullets();
			}

			// if the user has shots any bullets then execute the body
			if (model.bulletPool != null) {
				// gets an active bullet from the pool
				Bullet bullet = model.getActive();
				// if the bullet is not null then execute the body
				if (bullet != null) {
					// iterate throught the all the invaders
					for (int j = 0; j < model.invaders.size(); j++) {
						// sets the invader to a specific one in the array
						Invader invader = model.invaders.get(j);
						// if the bullet and invader are intersecting then execute the body
						if (bullet.image.getBoundsInParent().intersects(invader.invaderIcon.getBoundsInParent())) {
							// if the invader that is hit is the right answer then execute the body
							// else deduct a life and update the lives label
							if (invader.getLabel() == model.getAnswers()) {
								// advance the user to the next level
								model.nextLevel();
								// set the view according to the level the user is on
								view.setGame(model.level);
								// stop this timer and start the regular one
								invaderGameTimer.stop();
								regularGameTimer.start();
								// reset all bullets so none are on screen when the regular game starts
								model.resetAllBullets();
							} else {
								if (invader.getHit() == false) {
									invader.wrongAnswer();
									model.invaderDying.play();
									model.lives--;
									view.livesLabel.setText(String.valueOf(model.lives));
								}
							}
						}
					}
				}
			}

			// if the mouse is moved then exectute the handle method
			view.root.setOnMouseMoved((EventHandler<? super MouseEvent>) new EventHandler<MouseEvent>() {
				@Override
				public void handle(MouseEvent event) {
					// relative to center position/gun position (as x and y is given from top left
					// corner)
					// x and y are relative to the scene as the top left is 0,0 so i deduct values
					// relative to the guns position
					double mouseX = event.getSceneX() - 600;
					double mouseY = event.getSceneY() - 400;
					// converts x and y position to degrees
					double rotationDegrees = Math.toDegrees(-Math.atan2(mouseX, mouseY)) - 90;
					// turns the gun to the right direction
					model.gun.update(rotationDegrees);

				}
			});

			// if the mouse is clicked then exectute the handle method
			view.root.setOnMouseClicked((EventHandler<? super MouseEvent>) new EventHandler<MouseEvent>() {
				@Override
				public void handle(MouseEvent event) {
					// if the invaders game has started then execute the body
					if (model.invaderGameStarted == true) {
						//making a sound when the bullet is shot
						model.shootingSound.play();
						// retrieves a bullet that is not active from the pool
						Bullet bullet = model.getUnActive();
						double mouseX = event.getSceneX() - 600;
						double mouseY = event.getSceneY() - 400;
						// sets the angle of the bullet
						bullet.setAngle(mouseX, mouseY);
					}

				}
			});

		}
	};

	// if any keys are clicked then exectute the handle method
	EventHandler<KeyEvent> keyboardHandler = new EventHandler<KeyEvent>() {

		@Override
		public void handle(KeyEvent event) {

			// determines what key is pressed and updated the player icon upon that
			if (event.getCode() == KeyCode.W || event.getCode() == KeyCode.UP) {
				model.player.update("UP");
			} else if (event.getCode() == KeyCode.D || event.getCode() == KeyCode.RIGHT) {
				model.player.update("RIGHT");
			} else if (event.getCode() == KeyCode.S || event.getCode() == KeyCode.DOWN) {
				model.player.update("DOWN");
			} else if (event.getCode() == KeyCode.A || event.getCode() == KeyCode.LEFT) {
				model.player.update("LEFT");
			}

		}
	};

	public Controller(Model model, View view) {
		// TODO Auto-generated constructor stub
		super();
		this.model = model;
		this.view = view;

		// when the startButton is clicked then refer to the handle method
		this.view.startButton.setOnAction(this);
	}

	@Override
	public void handle(Event event) {
		// TODO Auto-generated method stub

		// if the start button has been clicked then call the setGame method from view
		// class
		if (event.getSource() == this.view.startButton) {
			regularGameTimer.start();
			// set the bullet pool to use when the game starts
			model.setBulletPool(view.graphicsContext, view.root, view.factory);
		}
	}

}
