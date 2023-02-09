const express = require("express");
const welcome = require("./resources/views/welcome");

const app = express();
app.use(express.json());

app.use("/welcome", welcome);

const PORT = process.env.PORT || 5000;

app.listen(PORT, () => {
    console.log("Server is running....");
});
