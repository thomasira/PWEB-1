
<main>
    <article class="profile-user">
        <header>
            <h2>{{ customer.name }}</h2>
            <p>customer id: {{ customer.user_id }}</p>
        </header>
        <section>
            <h3>My stamps</h3>
            <ul>
            {% for stamp in stamps %}
                <li class="item-row">
                    <a href="{{ path }}stamp/show/{{ stamp.id }}">{{ stamp.name }}</a>
                    <div>
                        <form action="{{ path }}stamp/edit" method="post">
                            <input type="hidden" name="id" value="{{ stamp.id }}">
                            <input type="submit" class="icon" value="&#9998;">
                        </form>
                        <form action="{{ path }}stamp/delete" method="post">
                            <input type="hidden" name="id" value="{{ stamp.id }}">
                            <input type="submit" class="icon" value="&#128465;">
                        </form>
                    </div>
                    </li>
            {% endfor %}
            </ul>
            <a href="{{ path }}stamp/create" class="button">add stamp</a>
        </section>
        <section>
            <a href="{{ path }}user/edit" class="button">modify info</a>
            <form action="{{ path }}customer/delete" method="post">
                <input type="hidden" name="id" value="{{ customer.user_id }}">
                <input type="submit" class="button warning" value="delete account">
            </form>
        </section>

    </article>
</main>