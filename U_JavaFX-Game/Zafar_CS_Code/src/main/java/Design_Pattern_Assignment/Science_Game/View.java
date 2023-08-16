package Design_Pattern_Assignment.Science_Game;

import javafx.scene.Cursor;
import javafx.scene.ImageCursor;
import javafx.scene.Scene;
import javafx.scene.canvas.Canvas;
import javafx.scene.canvas.GraphicsContext;
import javafx.scene.control.Button;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;
import javafx.scene.paint.Color;
import javafx.scene.shape.Rectangle;
import javafx.scene.text.Font;
import javafx.scene.text.FontWeight;
import javafx.scene.text.Text;


public class View {

	Pane root;
	Model model;
	GraphicsContext graphicsContext;
	Canvas canvas;
	Factory factory;
	Scene scene;
	Image map;

	// Field to reference start button on menu, so controller can identify it
	Button startButton;

	// Field for lives, for controller to update via the model
	Text livesLabel;

	// Field for shooting cool down for the controller to update via the model
	Rectangle coolDownTimer;

	/**
	 * @param root
	 * @param model
	 * @param graphicsContext
	 * @param canvas
	 * @param scene
	 */
	public View(Pane root, Model model, GraphicsContext graphicsContext, Canvas canvas, Scene scene) {
		// TODO Auto-generated constructor stub
		super();
		this.canvas = canvas;
		this.root = root;
		this.model = model;
		this.graphicsContext = graphicsContext;
		this.factory = new Factory(this.graphicsContext, root);
		this.scene = scene;

		// a call to the setMenu method, which shows the user the menu
		setMenu();

	}

	/**
	 * a method that sets the view for the menu
	 */
	public void setMenu() {

		// Fills the graphicsContext and places a picture in the background
		graphicsContext.fillRect(0, 0, 1200, 800);
		Image image = new Image(View.class.getResource("Menu.jpg").toExternalForm());
		graphicsContext.drawImage(image, 0, 0, 1200, 800);

		// sets the cursor to defualt
		root.setCursor(Cursor.DEFAULT);

		// sets up a button that is a start button
		// that triggers the game to start
		startButton = new Button("Start Game");
		startButton.setMinWidth(250);
		startButton.setMinHeight(35);
		root.getChildren().add(startButton);

		startButton.setLayoutX(500);
		startButton.setLayoutY(400);

		// sets up a border for the title
		Rectangle titleBorder = new Rectangle(350, 80);
		titleBorder.setStroke(Color.WHITE);
		titleBorder.setStrokeWidth(4);
		titleBorder.setFill(null);
		titleBorder.setLayoutX(450);
		titleBorder.setLayoutY(200);

		// setting up a text variable that is the title of the game
		Text title = new Text("Science Game");
		title.setFill(Color.WHITE);
		title.setFont(Font.font("Tw Cen MT Condensed", FontWeight.SEMI_BOLD, 50));
		title.setLayoutX(525);
		title.setLayoutY(250);

		root.getChildren().addAll(title, titleBorder);
	}

	/**
	 * a method that sets the view for the invaders game
	 */
	public void setInvadersGame() {

		// Clear the map of the page and set the invaders up
		this.root.getChildren().clear();
		this.root.getChildren().add(canvas);

		// Clearing images of the graphics Context
		this.graphicsContext.clearRect(0, 0, 1200, 800);

		// Filling the background as black
		this.graphicsContext.fillRect(0, 0, 1200, 800);

		// Setting the cursor image as a reticle
		Image cursorImage = new Image(View.class.getResource("reticle4.png").toExternalForm());
		root.setCursor(new ImageCursor(cursorImage));

		Gun gun = (Gun) factory.createProduct("Gun", 600, 400, null);

		// Adding a life counter to the view
		Image image = new Image(View.class.getResource("LiveCounter.png").toExternalForm(), 50, 50, false, false);
		graphicsContext.drawImage(image, 50, 700);
		livesLabel = new Text(String.valueOf(model.lives));
		livesLabel.setFill(Color.WHITE);
		livesLabel.setFont(Font.font("Tw Cen MT Condensed", FontWeight.SEMI_BOLD, 25));
		livesLabel.setLayoutX(100);
		livesLabel.setLayoutY(735);

		// Adding the Question
		Text question = new Text(model.arrayOfQuestions[model.level]);
		question.setFill(Color.WHITE);
		question.setFont(Font.font("Tw Cen MT Condensed", FontWeight.SEMI_BOLD, 50));
		question.setLayoutX(250);
		question.setLayoutY(50);

		root.getChildren().addAll(question, livesLabel);

		// Letting the model know the invaders game has started
		this.model.invaderGameStarted = true;
		this.model.gun = gun;

		// adds 8 invaders to the scene
		for (int i = 0; i < 8; i++) {

			double angle = 2 * i * Math.PI / 8;

			double xOffset = Invader.distance * Math.cos(angle);
			double yOffset = Invader.distance * Math.sin(angle);

			double x = Invader.centerX + xOffset;
			double y = Invader.centerY + yOffset;

			this.model.invaders.add((Invader) factory.createProduct("Invader", x, y, model.getPossibleAnswers()[i]));
		}

	}

	/**
	 * @param level sets the game up depending upon what level the user is on
	 */
	public void setGame(int level) {

		// Clear all of the elements on the menu page
		this.root.getChildren().clear();
		this.root.getChildren().add(canvas);

		// Clear the graphicsContext i.e images
		this.graphicsContext.clearRect(0, 0, 1200, 800);

		root.setCursor(Cursor.DEFAULT);

		// Insert the image of the map onto the graphics context
		Image map = new Image(View.class.getResource("Map.png").toExternalForm());

		// draws the map onto the graphicsContext
		this.graphicsContext.drawImage(map, 0, 0, 1200, 800);

		// Sets the gameStarted variable in the model to true
		this.model.gameStarted = true;
	}

	/**
	 * sets the view to a winning scene
	 */
	public void displayWin() {

		// Clear all of the elements on the menu page
		this.root.getChildren().clear();
		this.root.getChildren().add(canvas);

		// Clear the graphicsContext i.e images
		this.graphicsContext.clearRect(0, 0, 1200, 800);

		Image map = new Image(View.class.getResource("Win.jpg").toExternalForm());

		this.graphicsContext.drawImage(map, 0, 0, 1200, 800);

	}

	/**
	 * sets the view to a instructions scene
	 */
	public void setInstruction() {

		// Clear all of the elements on the menu page
		this.root.getChildren().clear();
		this.root.getChildren().add(canvas);

		// Clear the graphicsContext i.e images
		this.graphicsContext.clearRect(0, 0, 1200, 800);

		// Filling the graphicsContext black
		this.graphicsContext.fillRect(0, 0, 1200, 800);

		Image movementGuide1 = new Image(View.class.getResource("MovementPicture.jpg").toExternalForm(), 200, 200,
				false, false);
		Image movementGuide2 = new Image(View.class.getResource("movementPicture2.png").toExternalForm(), 180, 180,
				false, false);

		// Adding a disclaim
		String noCheating = "No Cheating Visit all Wooden Signs to vist each level... If you return home without completing each level you will not be let inside!";
		Text disclaimer = new Text(noCheating);
		disclaimer.setFill(Color.WHITE);
		disclaimer.setFont(Font.font("Tw Cen MT Condensed", FontWeight.SEMI_BOLD, 25));
		disclaimer.setLayoutX(150);
		disclaimer.setLayoutY(50);

		// Adding a movementPrompt
		String movementMessage = "Here are your movement Keys";
		Text movementPrompt = new Text(movementMessage);
		movementPrompt.setFill(Color.WHITE);
		movementPrompt.setFont(Font.font("Tw Cen MT Condensed", FontWeight.SEMI_BOLD, 25));
		movementPrompt.setLayoutX(450);
		movementPrompt.setLayoutY(100);

		this.graphicsContext.drawImage(movementGuide1, 325, 200);
		this.graphicsContext.drawImage(movementGuide2, 575, 200);

		// Adding a movementPrompt
		String waitingMessage = "We are setting up a few things, please wait...";
		Text waitingPrompt = new Text(waitingMessage);
		waitingPrompt.setFill(Color.WHITE);
		waitingPrompt.setFont(Font.font("Tw Cen MT Condensed", FontWeight.SEMI_BOLD, 25));
		waitingPrompt.setLayoutX(400);
		waitingPrompt.setLayoutY(500);

		// adds all of the variables to scene
		this.root.getChildren().addAll(disclaimer, movementPrompt, waitingPrompt);
	}
}
