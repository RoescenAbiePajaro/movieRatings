import express from 'express';
import cors from 'cors';
import bodyParser from 'body-parser';
import { movies } from './data';


//import

const app = express();
const port = 5000;

app.use(cors());
app.use(bodyParser.json());

// Get movies and ratings
app.get('/movies', (req, res) => {
  res.json(movies);
});

// Post a rating
app.post('/rate', (req, res) => {
  const { movieId, rating } = req.body;
  const movie = movies.find((m) => m.id === movieId);
  if (movie) {
    movie.ratings.push(rating);
    movie.averageRating = movie.ratings.reduce((acc, curr) => acc + curr, 0) / movie.ratings.length;
    res.json(movie);
  } else {
    res.status(404).send({ message: 'Movie not found' });
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
