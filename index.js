const express = require("express");
const app = express();

require("dotenv").config();

app.use(express.urlencoded({ extended: false }));
app.use(express.json());

const postsRouter = require("./routes/web");
const authRouter = require("./routes/auth");

app.use("/api/v1/web", postsRouter);
app.use("/api/v1/auth", authRouter);

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
    console.log("Server is running....");
});
