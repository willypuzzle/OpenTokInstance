const jwtBuilder = require( 'jwt-builder' );

let token = jwtBuilder( {
    algorithm: 'HS256',
    secret: '',
    nbf: true,
    exp: 24*3600,
    iss: "",
    ist: "project",
    jti: "jwt_nonce"
});

console.log(token)