
describe('Todo data entry with form', () => {
    //FASE LOGIN
    const email = 'team@webmapp.it'
    const password = 'webmapp'
    var id, instance, job, parameters

    it('e2e1', () => {
        cy.visit('/login')
        const a = 'team';
        cy.get('input[name=email]').type(email)
        cy.get('input[name=password]').type(password)
        cy.get('button').contains('Login').click()

        //ASSERT HOME BASE
        cy.url().should('contain', '/')

        cy.get('span#link_todo').click()

        //ASSERT archive
        cy.url().should('contain', '/todo')
        cy.get('svg.w-6.h-6.inline-block').click()
        cy.get('body > div > main > div > div > div.flex-1.flex.flex-col.overflow-hidden > main > div > div > div > div > div.mb-8 > div > div > div> form > div > div > div:nth-child(2) > button > i').click()
        //data entry with controls on form
        cy.get('svg.w-6.h-6.inline-block').click()
        cy.get('#cancelButton').contains('Cancel').click()
        cy.get('svg.w-6.h-6.inline-block').click()
        cy.get('#insertButton').contains('Insert').click()
        cy.get('input#exampleFormControlInput1').type('elm.be.webmapp.it')
        cy.get('#exampleFormControlInput2').type('update_route')
        cy.get('#exampleFormControlInput3').type('nedo')
        cy.get('#insertButton').contains('Insert').click()
        cy.get('#exampleFormControlInput3').clear()
        cy.get('#exampleFormControlInput3').type("{{}\"id\":1904}")
        cy.get('#insertButton').contains('Insert').click()

        cy.get('body > div > main > div > div > div > main > div > div > div > div > div> div > div > p').invoke('text').then((text) => {

            cy.log(text)
            id = text.split(' ')[4]
            instance = text.split(' ')[6]
            job = text.split(' ')[8]
            parameters = text.split(' ')[10]
            parameters = parameters.split('\n')[0]


            cy.log(id)
            cy.log(instance)
            cy.log(job)
            cy.log(parameters)

            cy.visit('/'+id+"/show")
            cy.url().should('contain', '/'+id+"/show")
            cy.get('h4#idTask').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain(id)

            })
            cy.get('h4#idInstance').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain(instance)

            })
            cy.get('h4#idJob').each(($e, index, $list) => {
                const text = $e.text()
                expect(text).to.contain(job)

            })
            cy.get('h4#idParameters').each(($e, index, $list) => {
                const text = $e.text()
                var p1 = JSON.stringify(text)
                var p2 = JSON.stringify(parameters)
                p1=p1.replace(/\s/g, '');
                p2=p2.replace(/\s/g, '');
                p2 = p2.substr(1,p2.length)
                expect(p1).to.contain(p2)
            })

        })

        cy.get('button.flex.text-sm.border-2.border-transparent.rounded-full').click()
        cy.get('a.block.px-4.py-2.text-sm.leading-5.text-gray-700').contains('Logout').click()

    })
})
