from flask import render_template
import views

def setup_urls(app):
    """URLs for the Home functions"""

    app.add_url_rule('/browse', view_func=views.BrowseView.as_view('browse'))