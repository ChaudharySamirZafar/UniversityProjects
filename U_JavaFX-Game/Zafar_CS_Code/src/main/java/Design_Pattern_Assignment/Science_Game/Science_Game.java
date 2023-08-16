package Design_Pattern_Assignment.Science_Game;

import javafx.application.Application;
import javafx.scene.Scene;
import javafx.scene.canvas.Canvas;
import javafx.scene.canvas.GraphicsContext;
import javafx.scene.layout.Pane;
import javafx.stage.Stage;

public class Science_Game extends Application {

	View view;
	Model model;
	Controller controller;

	Canvas canvas;
	GraphicsContext graphicsContext;
	Scene scene;
	Pane root;

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		launch(args);
	}

	@Override
	public void start(Stage primaryStage) throws Exception {
		// TODO Auto-generated method stub
		// creates a Pane
		root = new Pane();
		// creating a new scene and canvas
		scene = new Scene(root, 1200, 800);
		canvas = new Canvas(1200, 800);

		// initalising the graphicsContext
		graphicsContext = canvas.getGraphicsContext2D();
		// setting the scene and showing it
		primaryStage.setScene(scene);
		primaryStage.show();

		// not allowing the user to resize the tabf
		primaryStage.setResizable(false);

		// adding the canvas to the scene
		root.getChildren().add(canvas);

		// initalising MVC
		model = new Model();
		view = new View(root, model, graphicsContext, canvas, scene);
		controller = new Controller(model, view);

	}
}
