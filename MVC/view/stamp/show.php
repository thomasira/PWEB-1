
<main>
    <article class="file-stamp">
        <header>
            <h2>{{ stamp.name }}</h2>
            <p>Customer id: {{ stamp.customer_user_id }}</p>
        </header>
        <figure>
            <img src="{{ path }}assets/image/{{ stamp.image_link }}" alt="">
        </figure>
        <section>
            <div>
                <h4>Details</h4>
                <p>
                    <small>origin:</small> 
                    {% if stamp.origin %} {{ stamp.origin }} 
                    {% else %}Undefined {% endif %}
                </p>
                <p>
                    <small>year:</small> 
                    {% if stamp.year and (stamp.year != 0) %} {{ stamp.year }} 
                    {% else %}Undefined {% endif %}
                </p>
                <p>
                    <small>aspect:</small> 
                    {% if aspect.aspect %} {{ aspect.aspect }} 
                    {% else %}Undefined {% endif %}
                </p>
            </div>
            <aside>
                <h4>Categories</h4>
                {% if categories is iterable %}
                    {% for category in categories %}
                    <p>{{ category.category }}</p>
                    {% endfor %}
                {% else %}
                    <p>no categories</p>
                {% endif %}
            </aside>
        </section>
        <section>
            <h4>Description</h4>
            <p>
                {% if stamp.description %} {{ stamp.description }} 
                {% else %}No description {% endif %}
            </p>
        </section>
       
    </article>
</main>