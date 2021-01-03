
describe('Menu Profile and API', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('Test Profile and API', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('Profile').click()
        cy.url().should('contain', '/user/profile')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').should('exist')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Dashboard').should('exist')
        cy.contains('Dashboard').click()
        cy.url().should('contain', '/')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('Profile').click()
        cy.url().should('contain', '/user/profile')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Todo').click()
        cy.url().should('contain', '/todo')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('Profile').click()
        cy.url().should('contain', '/user/profile')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Done').click()
        cy.url().should('contain', '/done')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('Profile').click()
        cy.url().should('contain', '/user/profile')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Error').click()
        cy.url().should('contain', '/error')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('Profile').click()
        cy.url().should('contain', '/user/profile')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Duplicate').click()
        cy.url().should('contain', '/duplicate')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('Profile').click()
        cy.url().should('contain', '/user/profile')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Info').click()
        cy.url().should('contain', '/info')


        //API tokens
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('API Tokens').click()
        cy.url().should('contain', '/user/api-tokens')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').should('exist')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Dashboard').should('exist')
        cy.contains('Dashboard').click()
        cy.url().should('contain', '/')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('API Tokens').click()
        cy.url().should('contain', '/user/api-tokens')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Todo').click()
        cy.url().should('contain', '/todo')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('API Tokens').click()
        cy.url().should('contain', '/user/api-tokens')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Done').click()
        cy.url().should('contain', '/done')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('API Tokens').click()
        cy.url().should('contain', '/user/api-tokens')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Error').click()
        cy.url().should('contain', '/error')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('API Tokens').click()
        cy.url().should('contain', '/user/api-tokens')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Duplicate').click()
        cy.url().should('contain', '/duplicate')

        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(2) > div > nav > div.max-w-7xl.mx-auto.px-4.sm\\:px-6.lg\\:px-8 > div > div.hidden.sm\\:flex.sm\\:items-center.sm\\:ml-6 > div > div:nth-child(1) > button').click()
        cy.contains('API Tokens').click()
        cy.url().should('contain', '/user/api-tokens')
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > header > div:nth-child(1) > button > svg').click()
        cy.contains('Info').click()
        cy.url().should('contain', '/info')

    })
})
