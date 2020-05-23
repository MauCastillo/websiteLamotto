from django.urls import path
from .views.home import views

urlpatterns = [
    path('', views.home, name='home'),
]