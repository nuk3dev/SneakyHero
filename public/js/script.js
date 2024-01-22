//When document is loaded it shows the modal.
$(function() {
    $("#myModal").modal('hide');
    });

 //Makes the modal stay even though the player tries to away from the modal.
$('#myModal').modal({backdrop: 'static', keyboard: false});

//Gets the id of the canvas and puts that into a variable.
const canvas = document.getElementById("gameCanvas");

//Gets the id of the layout and puts that into a variable.
let layout = document.getElementById('menu-layout');

//Gets the id of the leaderboard and puts that into a variable.
let leaderboard = document.getElementById('leaderboard');

//Creates a two dimensional drawing canvas.
const ctx = canvas.getContext("2d");

//Default doesnt show the leaderboard.
leaderboard.style.display = 'none';

        //Player object with stats.
        const player = {
            image: '/img/character.png',
            x: 50,
            y: canvas.height - 50,
            width: 30,
            height: 30,
            speed: 5,
            acceleration: 10,
            maxSpeed: 10,
            jumping: false,
            jumpHeight: 150,
            jumpCount: 0,
            gravity: 1.5,
            velocityX: 0,
        };
        //Boss object with stats.
        const boss = {
            x: 700,
            y: canvas.height - 100,
            width: 50,
            height: 50,
            shootAngleRange: 130,
            speed: 10,
            shootInterval: 1500,
        }

        //Image player model.
        var image = new Image();
        image.src = 'img/character.png';



        //Everything that's created for and in the canvas.
        function manifest() {

            //Clears the pixels on the canvas.
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            //Renders platforms and the color.
            ctx.fillStyle = "white";
            platforms.forEach((platform) => {
                ctx.fillRect(platform.x, platform.y, platform.width, platform.height);
            });

            //Styling for player and placement on the canvas.
            ctx.drawImage(image, player.x, player.y, player.width, player.height);

            //Styling for boss and placement on the canvas.
            ctx.fillStyle = "white";
            ctx.fillRect(boss.x, boss.y, boss.width, boss.height);

            //Displaying the time on the canvas itself and the styling.
            var gameStop = Date.now();
            let secondsPlayed = (gameStop - timeStart) / 1000;
            ctx.fillStyle = "white";
            ctx.font = "30px VT323";
            ctx.fillText("Time: " + secondsPlayed ,10,75);

        }

        //Platform white lines on the canvas, the player can jump on them.
        const platforms = [
            { x: 0, y: canvas.height - 20, width: 800, height: 20 },
            { x: 100, y: canvas.height - 100, width: 200, height: 10 },
            { x: 400, y: canvas.height - 100, width: 200, height: 10 },
        ];

        //Player controls, when nothing is pressed they stand still.
        let leftPressed = false;
        let rightPressed = false;

         //Event listener for key presses A,D,jump and arrowkeys.
         window.addEventListener("keydown", (e) => {
            if (e.key === " " || e.key === "arrowup") {
                if (!player.jumping && player.jumpCount < 2) {
                    player.jumping = true;
                    player.jumpCount++;
                    jump();
                }
            }
            if (e.key === "ArrowLeft" || e.key === "a" || e.key === "A") {
                leftPressed = true;
            }
            if (e.key === "ArrowRight" || e.key === "d" || e.key === "D") {
                rightPressed = true;
            }
        });

        window.addEventListener("keyup", (e) => {
            if (e.key === "ArrowLeft" || e.key === "a" || e.key === "A") {
                leftPressed = false;
            }
            if (e.key === "ArrowRight" || e.key === "d" || e.key === "D") {
                rightPressed = false;
            }
        });

        //Compares the velocity and acceleration when moving.
        function checkLeftPressed() {
            if (leftPressed) {
                player.velocityX -= player.acceleration;
            } else if (rightPressed) {
                player.velocityX += player.acceleration;
            } else if (player.velocityX > 0) {
                player.velocityX -= player.acceleration;
            } else if (player.velocityX < 0) {
                player.velocityX += player.acceleration;
            }
        }

        //Limits the players speed.
        function limitPlayerSpeed() {
            if (player.velocityX > player.maxSpeed) {
                player.velocityX = player.maxSpeed;
            } else if (player.velocityX < -player.maxSpeed) {
                player.velocityX = -player.maxSpeed;
            }
        }

        //Substracs the player y position - the jump height of the player, then its true. and has a cooldown.
        function jump() {
            player.y -= player.jumpHeight;
            player.jumping = true;
            setTimeout(() => {
                player.jumping = false;
            }, 500);
        }

        //Platform collision, so that the player itself can stand on the platforms and not fall off.
        function platformCollision() {
            platforms.forEach((platform) => {
                if (
                    player.x + player.width > platform.x &&
                    player.x < platform.x + platform.width &&
                    player.y + player.height > platform.y &&
                    player.y < platform.y + platform.height
                ) {
                    player.jumpCount = 0;
                    player.y = platform.y - player.height;
                    player.velocityX = 0;
                }
            });
        }

        //Puts the particles in the array from the spawnParticles() function.
        particles = [];

        //Draws the particle shape and makes a loop everytime it gets drawn.
        function drawParticles() {
            for (const particle of particles) {
                ctx.fillStyle = particle.color;
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        //Spawn cooldown of the particles.
        function spawnParticles() {
            const currentTime = Date.now();
            if (!boss.lastShotTime || currentTime - boss.lastShotTime >= boss.shootInterval) {
                boss.lastShotTime = currentTime;

                //Calculate the angle for the boss shooting range.
                const angle = (5 * boss.shootAngleRange - boss.shootAngleRange / 2) * Math.PI;
                particles.push({
                    x: boss.x + boss.width / 2,
                    y: boss.y + boss.height,
                    radius: 125,
                    color: 'white',
                    speedX: Math.cos(angle) * 2,
                });
            }
        }

        /**
         * Particle collison for calculating both xy position and  height/width of objects when they hit.
         * @param player The player object.
         * @param particles  An array of particle objects.
         * @return boolean.
         */
        function detectParticleCollision(player, particles) {

            for (let i = 0; i < particles.length; i++) {
                const particle = particles[i];
                particle.x += particle.speedX;
                const dx = particle.x - (player.x + player.width / 2);
                const dy = particle.y - (player.y + player.height / 2);
                const distance = Math.sqrt(dx * dx + dy * dy);

                //When out of the canvas they get removed.
                if (distance < particle.radius + player.width / 2) {
                    particles.splice(i, 1);
                    i--;
                    gameOver = true;
                }

            }

        }

         /**
         * Collision for the boss, if the player is able to touch the boss, it's game over.
         * @param boss The boss object.
         * @param player The player object.
         * @return boolean.
        */
         function bossCollison(boss) {
            if(
                player.x + player.width > boss.x &&
                player.x < boss.x + boss.width &&
                player.y + player.height > boss.y &&
                player.y < boss.y + boss.height
            ) {
                player.jumpCount = 0;
                player.velocityX = 0;
                player.y = boss.y - player.height;
                gameOver = true;
            }
        }

        //Game begins, if true game is over.
        var gameOver = true;

       //If game is false it does all the functions in one function.
        function gameLoop() {
            if (!gameOver) {
                //Apply gravity.
                player.y += player.gravity;
                checkLeftPressed();
                spawnParticles();
                limitPlayerSpeed();
                bossCollison(boss);
                 detectParticleCollision(player, particles);
                //Apply velocity.
                player.x += player.velocityX;
                manifest();
                platformCollision();
                drawParticles();
                requestAnimationFrame(gameLoop);
            } else {
                gameEnd();
            }
        }

       // When player clicks on button with function playGame(),
       // it makes the menu display none, so you dont see the menu when you are playing.
        function playGame() {
            layout.style.display = "none";
            canvas.style.display = "block";
            timer.style.display = "block";
            leaderboard.style.display = 'none';
            gameOver = false;
            timeStart = Date.now();
            console.log("start : " + timeStart);
            gameLoop();
        }

        //When on leaderboard it only shows the leaderboard, not the canvas and layout.
        function showLeaderboard() {
            layout.style.display = 'none';
            canvas.style.display =  'none';
            timer.style.display = 'none';
            leaderboard.style.display = 'block';
        }

        //When on a page and when to go back to main menu that's what this function does.
        function goBackMenu() {
            layout.style.display = 'block';
            canvas.style.display =  'none';
            timer.style.display = 'none';
            leaderboard.style.display = 'none';
        }

        //When it's game over/ the player gets hits, it puts all the seconds into the var secondsPlayed,
        //Then it replaces the url with sneakyhero, so the player can go back to the main menu automically.
        function gameEnd() {
            var gameStop = Date.now();
            let secondsPlayed = (gameStop - timeStart) / 1000;
            ctx.font = "100px VT323";
            console.log("end: " + secondsPlayed)
            gameOver = true;
            bossCollison(boss);
            $("#myModal").modal('show');
            leaderboard.style.display = 'none';
            $('#myModal').on('hidden.bs.modal', function (e) {
                sendScore(secondsPlayed);
            });

            /**
             * This function sends the score and username to the database via Ajax call (API call).
             * @param secondsPlayed Seconds played var.
             * @return boolean.
             */
            function sendScore(secondsPlayed) {
                $.ajax({
                    url: "/api",
                    method: 'POST',
                    data: {
                        'username': $("#username").val(),
                        'secondsplayed': secondsPlayed,
                    },
                    success: function(result){
                        console.log("success", result);
                        let data = JSON.parse(result);
                        if(data.success == true) {
                            console.log($("#username").val(), secondsPlayed);
                           $alert =  alert(data.message);

                           layout.style.display = 'block';
                           canvas.style.display = "none";
                           timer.style.display = "none";
                        }

                    },
                    error: function() {
                        console.log("error");
                    }
                });
            }
        }

