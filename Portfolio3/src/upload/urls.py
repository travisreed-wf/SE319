from flask import render_template
import views

def setup_urls(app):
    """URLs for the Home functions"""

    app.add_url_rule('/upload', view_func=views.UploadView.as_view('upload'))