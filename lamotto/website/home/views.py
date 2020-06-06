from django.shortcuts import render
from .models import Manufacture


# Create your views here.
def home(request):
    manufacture = Manufacture.objects.all()
    return render(request, 'index.html', {'manufactures': manufacture})