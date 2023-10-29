
<main>
    <header>
        <h2>All users</h2>
    </header>
    <section>
        {% for customer in customers %}
        <article>
            <a href="{{ path }}customer/show/{{ customer.id }}"><h2>{{ customer.name }}</h2></a>
            <ul>
                <li>Email: <span>{{ customer.email }}</span></li>
            </ul>
        </article>
        {% endfor %}
    </section>
</main>