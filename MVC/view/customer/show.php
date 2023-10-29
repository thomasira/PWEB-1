

<main>
    <article class="file-user">
        <header>
            <h2>{{ customer.name }}</h2>
            <p>user id: {{ customer.id }}</p>
        </header>
        <section>
            <h3>{{ customer.name }}'s stamps</h3>
            <div>
                {% for stamp in stamps %}
                    <a href="{{ path }}stamp/show/{{ stamp.id }}">{{ stamp.name }}</a>
                {% endfor %}
            </div>
        </section>
    </article>
</main>