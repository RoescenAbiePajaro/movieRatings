// import express from 'express';
// import { connect } from './connect';

// const app = express();
// app.use(express.json());

// app.post('/api/post', async (req, res) => {
//   const { movie_title, comment } = req.body;

//   if (!movie_title || !comment) {
//     return res.status(400).json({ error: 'Movie title and comment are required' });
//   }

//   try {
//     const connection = await connect();
//     await connection.execute(
//       'INSERT INTO movie_comments (movie_title, comment) VALUES (?, ?)',
//       [movie_title, comment]
//     );
//     connection.end();

//     res.json({ success: true, message: 'Comment submitted successfully!' });
//   } catch (error) {
//     console.error(error);
//     res.status(500).json({ error: 'Database error' });
//   }
// });

// app.listen(8080, () => {
//   console.log('Server running on http://localhost:8080');
// });
