import Test from 'supertest';
process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';

export function client(): Test.SuperTest<Test.Test> {
    return Test('https://localhost');
}
