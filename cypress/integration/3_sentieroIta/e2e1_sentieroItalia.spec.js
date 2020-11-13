describe('Final Test Sentiero Italia E2E1', () => {
    const email = 'gagliardi'
    const password = 'webmappForHoqu'
    var id
    var title

    it('update POI', () => {
        cy.visit('http://els.be.webmapp.it/wp-admin')
        cy.get('input[name=log]').type(email)
        cy.get('input[name=pwd]').type(password)
        cy.get('input#wp-submit').click()
        cy.url().should('contain', '/')
        //update POI
        cy.get('.wp-menu-name').contains('POI').click()
        cy.wait(2000)
        cy.get('tbody#the-list td').first().invoke('text').then((value) => {
            id = value.substring(0, 4);
            cy.visit('http://els.be.webmapp.it/wp-admin/post.php?post=' + id + '&action=edit&lang=it')

            title = tree_title()
            cy.get('#post-title-0').clear({
                force: true
            })
            cy.get('#post-title-0').type(title)
            cy.get('#editor > div > div > div.components-navigate-regions > div > div.block-editor-editor-skeleton__header > div > div.edit-post-header__settings > button.components-button.editor-post-publish-button.editor-post-publish-button__button.is-primary').click()
            cy.wait(10000)

            cy.request('GET', 'https://a.webmapp.it/els.be.webmapp.it/geojson/' + id + '.geojson').then((response) => {
                const obj = JSON.parse(response.body)
                assert.strictEqual(obj.properties.name, title, 'ok title')
            })
        })
    })
    function tree_title() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < 10; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    }

})
