const jwtBuilder = require( 'jwt-builder' );

let token = jwtBuilder( {
    algorithm: 'HS256',
    secret: '9ddf699b8936ae6f7a5b4f7419a5c30cd2592f9e',
    nbf: true,
    exp: 24*3600,
    iss: "3419812",
    ist: "project",
    jti: "jwt_nonce"
});

console.log(token)