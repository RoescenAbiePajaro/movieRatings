import express from 'express';
import { connect } from './connect';

const app = express();
app.use(express.json());

app.get('/api/get', async (req, res) => {
  const movieTitle = req.query.movie_title as string;

  if (!movieTitle) {
    return res.status(400).json({ error: 'Movie title is required' });
  }

  try {
    const connection = await connect();
    const [rows] = await connection.execute(
      'SELECT comment, created_at FROM movie_comments WHERE movie_title = ? ORDER BY created_at DESC',
      [movieTitle]
    );
    connection.end();

    res.json(rows);
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: 'Database error' });
  }
});

app.listen(8080, () => {
  console.log('Server running on http://localhost:8080');
});
