
describe('Button Skip Error', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'

    it('e2eReschedule', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')
        cy.get('body > div > main > div > div > div > header > div:nth-child(1) > button').click()

        cy.get('span#link_todo').click()

        //ASSERT error
        cy.url().should('contain', '/todo')

        //Check Cancel Button
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#buttonTodoSkip').click()
            cy.contains('Cancel').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
                expect(text1).to.eq(text2)
            })
        })

        //Check Reschedule Button Skip
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#buttonTodoSkip').click()
            cy.contains('Skip').click()

            //id via notification
            cy.get('body > div > main > div > div > div > main > div > div > div > div > div> div > div > p').invoke('text').then((text) => {
                var id = text.split(' ')[5]
                var idA = text1.split(' ')[5]
                cy.log(idA)

                expect(text1).to.eq('\n                                        \n                                            '+id+'\n                                        \n                                    ')
                cy.visit('/'+id+"/show")        })

            cy.get('h4#processStatus').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain('skip')

            })
        })
        cy.get('span#link_todo').click()

        //ASSERT error
        cy.url().should('contain', '/todo')
        //Check Cancel Button
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#buttonTodoRes').click()
            cy.contains('Cancel').click()

            cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').should((text2) => {
                expect(text1).to.eq(text2)
            })
        })

        //Check Reschedule Button Skip
        cy.get('#hometable > tbody > tr:nth-child(1) > td:nth-child(1)').invoke('text').then((text1) => {

            cy.get('#buttonTodoRes').click()
            cy.contains('Reschedule').click()

            //id via notification
            cy.get('body > div > main > div > div > div > main > div > div > div > div > div> div > div > p').invoke('text').then((text) => {
                var id = text.split(' ')[5]
                var idA = text1.split(' ')[5]
                cy.log(idA)

                expect(text1).to.eq('\n                                        \n                                            '+id+'\n                                        \n                                    ')
                cy.visit('/'+id+"/show")        })

            cy.get('h4#processStatus').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain('new')

            })
        })

    })






})
